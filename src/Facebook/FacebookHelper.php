<?php

namespace Meta\FacebookSDK;

class FacebookHelper
{
    public function __construct(private string $app_id){}

    public function javascriptSDK(string $language = 'en_US', bool $debugger = true): string
    {
        $script = "<script 
                async 
                defer 
                crossorigin='anonymous' 
                src='https://connect.facebook.net/$language/sdk.js'>    
            </script>";

        if ($debugger)
            $script .= "<script
                async
                defer
                crossorigin='anonymous'
                src='https://connect.facebook.net/$language/sdk/debug.js'>
            </script>";

        return $script;
    }

    public function javascriptLogin(string $function_name = 'login', bool $debugger = false): string
    {
        $script = $this->javascriptSDK(debugger:$debugger);

        return $script .= "<script>
            window.fbAsyncInit = function() {
                FB.init({
                      appId            : '$this->app_id',
                      autoLogAppEvents : true,
                      xfbml            : true,
                      version          : 'v14.0'
                });
            };
            
            function ".$function_name."()
            {
                 FB.login(function(auth) {
                 if (auth.authResponse) {
                     FB.api('/me', function(user) {
                        document.cookie = 'facebook_auth='+JSON.stringify([user, auth])
                     });
                 } else {
                    document.cookie = 'facebook_auth='+JSON.stringify({'error': true, 'message': 'Connection refused', 'code': 100})
                 }
                });
            }
        </script>";
    }

    public function javascriptLogout(string $function_name = 'logout', bool $debugger = false): string
    {
        $script = $this->javascriptSDK(debugger:$debugger);

        return $script .= "<script>
            window.fbAsyncInit = function() {
                FB.init({
                      appId            : '$this->app_id',
                      autoLogAppEvents : true,
                      xfbml            : true,
                      version          : 'v14.0'
                });
            };
            
            function ".$function_name."()
            {
                FB.logout(function(response) {
                    document.cookie = 'facebook_auth='
                });
            }
        </script>";
    }

    /**
     * @return string
     */
    public function getAppId(): string
    {
        return $this->app_id;
    }

    /**
     * @param string $app_id
     * @return FacebookHelper
     */
    public function setAppId(string $app_id): FacebookHelper
    {
        $this->app_id = $app_id;
        return $this;
    }
}