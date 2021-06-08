<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        tr:hover{
            background-color:lightgrey;
        }
        table{
            padding:10px;
            width:700px;
            border-collapse:collapse;
        }
        tr{
            border:none;
        }
        td{
            padding:5px;
            padding-right:20px;
            padding-left:20px;
            text-align: center;
            border:none;
        }
        .grey_tr{
            background-color:#dffdff;
        }
        .hidden_inp{
            /* display:none; */
        }
        button, input[type="button"]{
            margin: 10px;
            border-radius: 5px;
            border: none;
            width: 60px;
            height: 30px;
            box-shadow: 1px 1px 2px lightgrey;
        }
    
</style>
</head>
<body>
    <?php
        $from_url=parse_url($_SERVER['HTTP_REFERER']);
        $here_url=parse_url("http://192.168.1.180/php_playground/mysql/tab/print.php");
        $mysql=new mysqli("127.0.0.1","root","","20210415_test");
        // echo $here_url['path']."<br>";
        // print_r($from_url);
        // echo $_GET["refresh"];
        if($_GET["refresh"]==1){
            // echo "here";
            // $type_inp=$_POST["type_inp"];
            // echo $type_inp;
            $id=$_GET["id"];
            $name=$_GET["name"];
            $chi=$_GET["chi"];
            $eng=$_GET["eng"];
            $mat=$_GET["mat"];
            $sql_upt="UPDATE student SET name='".$name."', chi=".$chi.", eng=".$eng.", mat=".$mat." WHERE id='".$id."';";
            // echo "<br>".$sql_upt."<br>";
            $res=$mysql->query($sql_upt);
            $mysql->close();
            $id="";
            $name="";
        }else{
            $id=$_GET["id"];
            $name=$_GET["name"];
            $inp=$_GET["inp"];
            $grade=(int)$_GET["grade"];
        }
        
        $arr1=["","","","","WHERE"];
        $id_count=0;
        $count=0;
        if(isset($inp)){
            switch ($inp) {
                case 0: 
                    $inp='chi';
                    break;
                case 1:
                    $inp='eng';
                    break;
                case 2:
                    $inp='mat';
                    break;
            }
        }
        if(!empty($id)){
            $arr1[0]="id='".$id."'";
            $count++;
        }
        if(!empty($name)){
            $arr1[1]="name='".$name."'";
            $count++;
        }
        if(!empty($grade)){
            echo 1;
            $arr1[2]=$inp."=".$grade;
            $count++;
        }
        if($count==2){
            $arr1[3]="AND";
        }else if($count==0){
            $arr1[4]="";
        }
        $sql_ins="SELECT * FROM student ".$arr1[4]." ".$arr1[0]." ".$arr1[1]." ".$arr1[3]." ".$arr1[2].";";
        $mysql=new mysqli("127.0.0.1","root","","20210415_test");
        echo $sql_ins;
        $res=$mysql->query($sql_ins);
        $title=mysqli_fetch_fields($res);

        echo "<table>";
        echo "<tr>";
        foreach($title as $s){
            echo "<td>".$s->name."</td>";
        }
        echo "</tr>";
        while($row=mysqli_fetch_row($res)){
            echo "<tr onclick='_click(this)' id='a".$id_count."'>"; 
                foreach($row as $i){
                    echo "<td>".$i."</td>";
                }    
            echo "</tr>";
        }
        echo "</table>";
    ?> 

    <button onclick="cert_print()">Print</button>
    <!-- <form action="" method="get" id="_form">  -->
        <div id="show">
            <table>
                <tr class='grey_tr'>
                    <td class="put_text pt1" id="_id"></td>    
                    <td class="put_text pt2" id="_name"></td>
                    <td class="put_text pt3" id="_chi"></td>
                    <td class="put_text pt4" id="_eng"></td>
                    <td class="put_text pt5" id="_mat"></td>
                </tr>    
            </table>
            <!-- <input type="text" class="hidden_inp" name="_id" id="hid_id"> -->
            <!-- <input type="text" class="hidden_inp" name="_name" id="hid_name"> -->
            <!-- <input type="text" class="hidden_inp" name="_chi" id="hid_chi"> -->
            <!-- <input type="text" class="hidden_inp" name="_eng" id="hid_eng"> -->
            <!-- <input type="text" class="hidden_inp" name="_mat" id="hid_mat"> -->
            <button id="btn">Revise</button>
        </div>
    <!-- </form> -->
    
    <script>
        var tr_select=document.querySelectorAll('tr');
        count_tr=tr_select.length;
        var pt=document.querySelectorAll(".put_text");
        var id=document.getElementById("_id");
        var arr_inp={0:"", 1:"",2:'',3:'',4:""};
        var orign="";
        var hid_inp=document.querySelectorAll(".hidden_inp");
        var _form=document.getElementById("_form");
        var btn_=document.getElementById("btn");

        for(var a=0;a<pt.length;a++){ 
            pt[a].addEventListener("dblclick", function(){
                for(var k=2;k<5;k++){
                   arr_inp[k]=parseInt(pt[k].innerHTML);
                }
                arr_inp[0]=pt[0].innerHTML;
                console.log(arr_inp);
                arr_inp[1]=pt[1].innerHTML;
                orign=this.innerHTML;
                this.innerHTML="<input type='text' id='inp' name='type_inp'>";
                var _inp=this.querySelector("input");
                this.blur();
                _inp.focus();
                _inp.addEventListener("keyup", e=>{
                    if(e.key==="Enter"){ _inp.blur(); }
                    orign=_inp.value;    
                });
                _inp.addEventListener("blur", e=>{
                    _inp.parentElement.innerHTML=orign;
                    if(this.id=='_name'){
                        arr_inp[1]=orign;
                    }else if(this.id=='_chi'){
                        arr_inp[2]=parseInt(orign);
                    }else if(this.id=='_eng'){
                        arr_inp[3]=parseInt(orign);
                    }else if(this.id=='_mat'){
                        arr_inp[4]=parseInt(orign);
                    }
                console.log(arr_inp);
                console.log(hid_inp);
                });
                btn_.addEventListener("click", e=>{
                    location.href=`/php_playground/mysql/tab/print.php?id=${arr_inp[0]}&name=${arr_inp[1]}&chi=${arr_inp[2]}&eng=${arr_inp[3]}&mat=${arr_inp[4]}&refresh=1`;
                });
            });
        }
        function cert_print(){
            window.print();
        }
        function _click(t){
            var a=t.querySelectorAll("td");
            var pt=document.querySelectorAll(".put_text");
            var arr=Array();
            // console.log(pt);
            for(var i=0;i<a.length;i++){
                arr.push(a[i].innerHTML);
                pt[i].innerHTML=arr[i];
            }

        }
        for(var o=1;o<count_tr-1;o+=2){
            tr_select[o].className="grey_tr";
        }
    </script>    

</body>
</html>
