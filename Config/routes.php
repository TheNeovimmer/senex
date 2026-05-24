<?php

return
[
   
    "home"=>[
        "method"=>"GET",
        "controller"=>[\Controllers\HomeController::class,'showhomepage'],
        
    ],

        "contact"=>[
        "method"=>"GET",
        "controller"=>[\Controllers\ContactController::class,'showcontactpage'],
        
    ],
   "next"=>[
        "method"=>"GET",
        "controller"=>[\Controllers\ContactController::class,'shownextpage'],
        
    ],
       "replays"=>[
        "method"=>"GET",
        "controller"=>[\Controllers\ContactController::class,'showreplayspage'],
        
    ],
       "login"=>[
        "method"=>"GET",
        "controller"=>[\Controllers\ContactController::class,'showloginpage'],
        
    ],
       "signin"=>[
        "method"=>"GET",
        "controller"=>[\Controllers\ContactController::class,'showsigninpage'],
        
    ],
       "aboutus"=>[
        "method"=>"GET",
        "controller"=>[\Controllers\ContactController::class,'showaboutuspage'],
        
    ],
];
?>