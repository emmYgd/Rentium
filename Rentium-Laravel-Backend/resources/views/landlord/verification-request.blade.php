<!DOCTYPE html>
<html>
    <head>
        <style>
            .w3-myfont {
              font-family: "Comic Sans MS" ;
            }
        
            .w3-custom-purple {
              background: #6a41ed;
            }
            .w3-green {
                background: #008000
            }

            .w3-text-white {
                color: white
            }

            .w3-text-yellow{
                color: yellowgreen
            }

            .w3-center{
                justify-content: center
            }
            
        </style>
    </head>
    <body class="w3-myfont w3-custom-purple w3-text-white">
        <div class="w3-center">
        <br/><br/>
        <p>
            <strong> Hey <b>{{$landlord_request->landlord_full_name}}</b>,</strong>
        </p>

        <b><hr/></b>

        <p>
            <b> To continue with us, Please log into your rentium account and click on verify account:<br/><br/>
                Copy this token and paste it in the text box provided!:<br/><br/>
                <i>{{$verify_token}}</i>
            </b>
            <br/>
            <b> See you on the other side!</b>
        </p>

        <b><hr/></b>

        <p>
           <b> Cheers! </b>
        </p>
        <br/><br/>
        </div>
    </body>
</html>