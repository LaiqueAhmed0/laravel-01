<!DOCTYPE html>
<html style="background-color: rgba(0, 0, 0, .2);height: 100%; width: 100%;">
<body style="background: transparent;height: 100%; width: 100%;display: flex; align-content: center;justify-content: center" >

<form style="background: white;" id="cardsave-direct-3d-secure" action="{{$ACSURL}}" method="POST">
    <input type="hidden" name="PaReq" value="{{htmlspecialchars($PaREQ)}}"/>
    <input type="hidden" name="MD" value="{{htmlspecialchars($cross)}}"/>
    <input type="hidden" name="TermUrl" value="https://portal.mobile.brd.ltd{{$termURL}}"/>
    <p>Please click button below to Authenticate your card</p><input type="submit" value="Go"/></p>
</form>

<script type="text/javascript">
    document.getElementById('cardsave-direct-3d-secure').submit();
</script>
</body>
</html>
