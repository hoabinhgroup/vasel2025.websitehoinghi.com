<?php

namespace Modules\Analytics\Widgets;

use Modules\Base\Widgets\BaseAbstractWidget;
use Modules\Analytics\Exceptions\InvalidConfiguration;
use Modules\Analytics\Period;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Analytics;
use Carbon\Carbon;
use Exception;
use Throwable;

class AdminGoogleAnalyticsWidget extends BaseAbstractWidget
{
  /**
   * The configuration array.
   *
   * @var array
   */
  protected $config = [];

  public function run()
  {
    //

    $this->config = $this->getGeneral();
    //$this->config = 123;

    if (!is_array($this->config)) {
      return view("analytics::analytics.errors", [
        "config" => $this->config,
      ]);
    }

    return view("analytics::widgets.admin_google_analytics_widget", [
      "config" => $this->config,
    ]);
  }

  public function getGeneral()
  {
    $startDate = Carbon::today(config("app.timezone"))->startOfDay();
    $endDate = Carbon::today(config("app.timezone"))->endOfDay();
    $dimensions = "hour";

    try {
      $period = Period::create($startDate, $endDate);

      $visitorData = [];

      $answer = Analytics::performQuery($period, "ga:visits,ga:pageviews", [
        "dimensions" => "ga:" . $dimensions,
      ]);

      // dd($period);

      // $mostVisistedPages = Analytics::fetchMostVisitedPages($period, 200);

      if ($answer->rows == null) {
        $answer->rows = [];
      }

      if ($dimensions === "hour") {
        foreach ($answer->rows as $dateRow) {
          $visitorData[] = [
            "axis" => (int) $dateRow[0] . "h",
            "visitors" => $dateRow[1],
            "pageViews" => $dateRow[2],
          ];
        }
      } else {
        foreach ($answer->rows as $dateRow) {
          $visitorData[] = [
            "axis" => Carbon::parse($dateRow[0])->toDateString(),
            "visitors" => $dateRow[1],
            "pageViews" => $dateRow[2],
          ];
        }
      }

      $stats = collect($visitorData);
      $country_stats = Analytics::performQuery($period, "ga:sessions", [
        "dimensions" => "ga:countryIsoCode",
      ])->rows;
      $total = Analytics::performQuery(
        $period,
        "ga:sessions, ga:users, ga:pageviews, ga:percentNewSessions, ga:bounceRate, ga:pageviewsPerVisit, ga:avgSessionDuration, ga:newUsers"
      )->totalsForAllResults;

      // return $response->setData(
      //   view(
      //     "analytics::widgets.general",
      //     compact("stats", "country_stats", "total")
      //   )->render()
      // );

      return [
        "stats" => $stats,
        "country_stats" => $country_stats,
        "total" => $total,
        // "mostVisistedPages" => $mostVisistedPages,
      ];
    } catch (InvalidConfiguration $exception) {
      // dd($exception);
      return $exception->getMessage();
    } catch (Exception $exception) {
      echo 3434;
      return $exception->getMessage();
    }
  }
}
