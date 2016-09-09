<html>
<script type="text/javascript">
    stoptime = new Date(2016,9,9,16,24,9); //目標時間
    dateFuture1=stoptime.getTime();
    delete stoptime;

    function GetCount(ddate,iid){
        dateNow = new Date(); //現在時間
        amount = ddate - dateNow.getTime(); //時間差
        delete dateNow;
        if(amount < 0){ //過了該時間
            document.getElementById(iid).innerHTML="現在!!";
        }
        else{  //時間還沒到
            out="";
            amount = Math.floor(amount/1000);//去掉milliseconds
            days=Math.floor(amount/86400);//天
            amount=amount%86400;
            hours=Math.floor(amount/3600);//小時
            amount=amount%3600;
            mins=Math.floor(amount/60);//分
            amount=amount%60;
            secs=Math.floor(amount);//秒
            if(days != 0){out += days +" 天, ";}
            if(hours != 0){out += hours +" 小時, ";}
            out += mins +" 分, ";
            out += secs +" 秒";
            document.getElementById(iid).innerHTML=out;
            setTimeout(function(){GetCount(ddate,iid)}, 1000);
        }
    }

    window.onload=function(){
        GetCount(dateFuture1, 'countbox1');
    };
</script>

<div id="countbox1"></div>

</html>