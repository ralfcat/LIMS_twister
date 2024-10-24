<?php 
namespace NotifTemplate;
function notif_email($btype, $address) {

$msg_body =  '



<body style = "font-family: "Nunito", Helvetica, sans-serif; height: 100%; margin: 0; background-color: #f5d5dd; display: flex; flex-direction: column;">


   <div class="logo-container" style = "flex: 1;"> 
        <h1  style = "font-weight: 800;" >Low Blood Stock</h1>
        <p> Hej! We are running low on ' . $btype . ' in ' . $address . '! Visit your local blood center to donate</p>
           
</div>

    </main>

</body>


';

return $msg_body;

} 