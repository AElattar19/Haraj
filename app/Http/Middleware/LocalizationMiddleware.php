<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Schema::hasTable('migrations')) {

            if (\Schema::hasTable('visitors')) {
                // Code Add Visetor IP

                if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
                } //whether ip is from proxy
                elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } //whether ip is from remote address
                else {
                    $ip_address = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
                }
                // echo $ip_address;

                if (! visitor::where('ip', $ip_address)->first()) {

                    $agent = new Agent();
                    $server = $request->server();
                    $host = gethostbyaddr($server['REMOTE_ADDR']);
                    $data = [
                        'browser'          => $agent->browser(),
                        'host'             => $host,
                        'browser-version'  => $agent->version($agent->browser()),
                        'platform'         => $agent->platform(),
                        'platform_version' => $agent->version($agent->platform()),
                        'device_type'      => $agent->isDesktop() ? 'Desktop' : ($agent->isPhone() ? 'Phone' : ($agent->isTablet() ? 'Tablet' : $agent->device())),
                        'device_name'      => $agent->isRobot() ? $agent->robot() : 'Not Available',
                        'device_model'     => ! $agent->isDesktop() ? $agent->device() : 'Desktop',
                    ];

                    visitor::create(['ip' => $ip_address, 'data' => $data]);
                }
            }
        }

        if (session('locale')) {
            App::setLocale(session('locale'));
        } else {
            session()->put('locale', 'ar');
            session()->put('rtl', true);
            App::setLocale(session('locale'));
        }

        return $next($request);
    }
}
