<?php 
namespace Modules\Base\Http\Middleware;
use Closure;

class BeforeAutoTrimmer {
    
    public function handle($request, Closure $next)
    {
        $request->merge(array_map('trim', $request->all()));
        return $next($request);
    }
}
