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
            <strong> Hey <b>{{$landlord_request->landlord_first_name}}</b>,</strong>
        </p>

        <b><hr/></b>

        <p>
            <b> To continue with us, <a href="{{$verify_link}}"><i class="w3-text-yellow">click here</i></a> to verify your Wicart account or:<br/><br/>
                Copy and Follow this link on your favourite browser:<br/><br/>
                <i>{{$verify_link}}</i>
            </b>
        </p>

        <b><hr/></b>

        <p>
           <b> Cheers! </b>
        </p>
        <br/><br/>
        </div>
    </body>
</html>