<?php

namespace Modules\Base\Exceptions;

use App\Exceptions\Handler as ExceptionHandler;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Concerns\InteractsWithContentTypes;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Notifications\Notifiable;
use Theme;
use Throwable;
use URL;
use Log;

class Handler extends ExceptionHandler
{
    use Notifiable;
    /**
     * {@inheritDoc}
     */
    public function render($request, Throwable $exception)
    {
        if (
            $exception instanceof ModelNotFoundException &&
            $request->expectsJson()
        ) {
            return (new BaseHttpResponse())
                ->setError()
                ->setMessage("Not found")
                ->setCode(404)
                ->toResponse($request);
        }

        if (
            $exception instanceof ModelNotFoundException ||
            $exception instanceof MethodNotAllowedHttpException
        ) {
            $exception = new NotFoundHttpException(
                $exception->getMessage(),
                $exception
            );
        }

        if ($exception instanceof AuthorizationException) {
            $response = $this->handleResponseData(403, $request);
            if ($response) {
                return $response;
            }
        }

        if (
            $this->isHttpException($exception) &&
            !app()->isDownForMaintenance()
        ) {
            $code = $exception->getStatusCode();

            do_action(BASE_ACTION_SITE_ERROR, $code);

            if (in_array($code, [401, 403, 404, 500, 503])) {
                $response = $this->handleResponseData($code, $request);
                if ($response) {
                    return $response;
                }
            }
        } elseif (
            app()->isDownForMaintenance() &&
            view()->exists(setting("theme") . "::views.503")
        ) {
            return response()->view(
                setting("theme") . "::views.503",
                ["exception" => $exception],
                503
            );
        }

        return parent::render($request, $exception);
    }

    /**
     * @param integer $code
     * @param Request|InteractsWithContentTypes $request
     * @return bool|BaseHttpResponse|RedirectResponse|Response
     * @throws FileNotFoundException
     */
    protected function handleResponseData($code, $request)
    {
        if ($request->expectsJson()) {
            if ($code == 401) {
                return (new BaseHttpResponse())
                    ->setError()
                    ->setMessage(
                        trans("acl::permissions.access_denied_message")
                    )
                    ->setCode($code)
                    ->toResponse($request);
            }

            if ($code == 403) {
                return (new BaseHttpResponse())
                    ->setError()
                    ->setMessage(trans("acl::permissions.action_unauthorized"))
                    ->setCode($code)
                    ->toResponse($request);
            }
        }

        $code = (string) $code;
        $code = $code == "403" ? "401" : $code;
        $code = $code == "503" ? "500" : $code;

        if (
            $request->is(config("base.admin_dir") . "/*") ||
            $request->is(config("base.admin_dir"))
        ) {
            return response()->view("base::errors." . $code, [], $code);
        }

        if (view()->exists(setting("theme") . "::" . $code)) {
            return response()->view(setting("theme") . "::" . $code, [], $code);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception) && !$this->isExceptionFromBot()) {
            if (!app()->isLocal() && !app()->runningInConsole()) {
                if ($exception instanceof Exception) {
                    ray()->exception($exception)->hide();
                    ray('Error Url', request()->fullUrl());
                }
                if (
                    setting("enable_send_error_reporting_via_email", false) &&
                    setting("email_driver", config("mail.default"))
                ) {
                    if ($exception instanceof Exception) {
                        // echo 'Có lỗi. Check Handler'; die();
                        //  app()->make(new \Modules\Base\Notifications\NotifyLogs($exception));
                        // EmailHandler::sendErrorException($exception);
                    }
                }

                // if (
                //     !is_backend() &&
                //     setting("enable_send_error_reporting_via_telegram", false)
                // ) {
                //     if ($exception instanceof Exception) {
                //         // send error to telegram
                //         $user = new \App\User();
                //         $user->telegramid = \Config::get(
                //             "services.telegram_id"
                //         );
                //         $user->notice =
                //             $exception->getMessage() .
                //             "\n" .
                //             "Error Line:" .
                //             $exception->getLine() .
                //             "\n" .
                //             "Error Url:" .
                //             Url::full() .
                //             "\n" .
                //             "Ip address: " .
                //             request()->ip();
                //         $user->notify(
                //             new \Modules\Base\Notifications\NotifyLogs()
                //         );
                //     }
                // }
            }
        }

        parent::report($exception);
    }

    /**
     * Determine if the exception is from the bot.
     *
     * @return boolean
     */
    protected function isExceptionFromBot(): bool
    {
        $ignoredBots = config("base.error_reporting.ignored_bots", []);
        $agent = strtolower(request()->server("HTTP_USER_AGENT"));

        if (empty($agent)) {
            return false;
        }

        foreach ($ignoredBots as $bot) {
            if (strpos($agent, $bot) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    protected function unauthenticated(
        $request,
        AuthenticationException $exception
    ) {
        if ($request->expectsJson()) {
            return (new BaseHttpResponse())
                ->setError()
                ->setMessage($exception->getMessage())
                ->setCode(401)
                ->toResponse($request);
        }

        return redirect()->guest(route("access.login"));
    }
}
