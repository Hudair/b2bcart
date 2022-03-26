


    <h1>
        @if($status == 1)
        Deposit Completed Successfully
        @else
        Payment Not Suceesfull.
        @endif
    </h1>
    


<script type='text/javascript'>

    
    
  @if($status == 1)
   var data = '{"status":true, "data": "Balance has been added to your account successfully.", "error" : ""}';
  @else
   var data = '{"status": false, "data" : [], "error" : ["message" : "Payment Not Suceesfull."]}';
  @endif
  console.log(data);
  window.Print.postMessage(data);
  
    



  
  
  
  
//   function listenMessage(msg) {
//     alert(msg);
// }

// if (window.addEventListener) {
//     window.addEventListener("message", listenMessage, false);
// } else {
//     window.attachEvent("onmessage", listenMessage);
// }
  
  
  
</script>
