<form action="/account/login" method="post">
    <input type="text" name="name" value="Allen">
    <input type="submit" value="提交aa">
</form>
<input type="button" value="ajax提交bb" class="ajax">
<script src="../../js/jquery-1.10.2.min.js"></script>
<script>
    $(".ajax").click(function(){

        $.ajax({
            type: "get",
            url: "/account/register.php",
            dataType: "json",
            success: function(msg){

                alert(msg.message);

            }
        });
    });
</script>
<?php
echo 'index';