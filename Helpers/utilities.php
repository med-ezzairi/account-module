<?php

use Illuminate\Http\Response;



if( !function_exists('allowed') ){
    /**
     * Check if the user has the ability or not
     * 
     * @param string $ability
     * @return mixed|true|Response
     */
    function allowed( string $ability )
    {
        return app(Modules\Account\Contracts\Gate::class)->check($ability);
    }
}