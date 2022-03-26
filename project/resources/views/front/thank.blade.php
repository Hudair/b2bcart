
  <h1>
      @if($get == 1)
      Payment Completed Successfully
      @else
      Payment Not Suceesfull.
      @endif
  </h1>
    


<script type='text/javascript'>

  @if($get == 1)
   var data = '{"status":true, "data": "Payment Completed Successfully", "error" : ""}';
  @else
   var data = '{"status": false, "data" : [], "error" : ["message" : "Payment Not Suceesfull."]}';
  @endif
  console.log(data);
  window.Print.postMessage(data);
  
    
</script>
