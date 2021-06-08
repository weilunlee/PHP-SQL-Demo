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
            border-collapse:collapse;
            width:60%;
            height:50%;
            border:1px solid black;
        }
        tr{
            border:none;
        }
        td{
            padding:5px;
            padding-right:15px;
            padding-left:15px;
            text-align: center;
            border:none;
        }
        .grey_tr{
            background-color:#dffdff;
        }
    </style>
</head>
<body>  
    <a href="id.php">學生名單</a>
    <a href="chi.html">國文成績</a>
    <a href="eng.html">英文成績</a>
    <a href="mat.html">數學成績</a>
    <?php
        $i_name="";
        $chi=0;     
        $eng=0;
        $mat=0;
        $delete="";
        $mysql=new mysqli("127.0.0.1","root","","20210415_test");
        $sql_ins="SELECT * FROM student";
        $res_last=$mysql->query($sql_ins);
        $res_last_num=mysqli_num_rows($res_last);
        $sql_last_id="SELECT id FROM student ORDER BY id DESC";
        $res_last_id=$mysql->query($sql_last_id);
        $last_id=mysqli_fetch_row($res_last_id);
        $revise_last_id=substr($last_id[0],0,-1);
        $sql_dosth="";
        $temp="s1001";
        
        if(!empty($_POST['search'])){
            $inp=$_POST['search'];
        }else{
            $inp=$temp;
        }        
         
        // 新增
        if(isset($_POST["insert"])){
            $id=$_POST["search"];
            if(empty($_POST["search"])){
                $id=$revise_last_id.$res_last_num+1;
            }else{
                $checkbl=checkid($id);
            }

            if($checkbl==1){
                ?><script>alert("此id已存在!!!!!!");</script><?php
            }else if($checkbl==0){
                $i_name=$_POST["i_name"];
                $chi=$_POST['chi'];
                $eng=$_POST['eng'];
                $mat=$_POST['mat'];            
                $sql_dosth="INSERT INTO student(`id`, `name`,`chi`,`eng`,`mat`) VALUES ('$id','$i_name','$chi','$eng','$mat')";
                $res2=$mysql->query($sql_dosth);
            }
        }
        // 修改
        if(isset($_POST["update"])){
            $id=$inp;
            if(!empty($_POST["i_name"])){
                $i_name="name='".$_POST["i_name"]."'";
            }else{
                $i_name="";
            }
            if(!empty($_POST["chi"])){
                $chi="chi='".$_POST["chi"]."'";
            }else{
                $chi="";
            }
            if(!empty($_POST["eng"])){
                $eng="eng='".$_POST["eng"]."'";
            }else{
                $eng="";
            }
            if(!empty($_POST["mat"])){
                $mat="mat='".$_POST["mat"]."'";
            }else{
                $mat="";
            }
            $sql_dosth="UPDATE student SET ".$i_name.$chi.$eng.$mat." WHERE id='".$id."';";
            $res2=$mysql->query($sql_dosth);
        }
        // 刪除
        if(isset($_POST["delete"])){
            $delete=$inp;
            $sql_dosth="DELETE FROM student WHERE id='".$delete."';";
            $res2=$mysql->query($sql_dosth);
        }else{
            $delete="";
        }

        // 共用連線
        $res=$mysql->query($sql_ins);
        $n=mysqli_num_rows($res);
        echo "<script> var rows=".$n.";</script>";
        echo "<table>";
        echo "<tr>";
        foreach(mysqli_fetch_fields($res) as $i){
            echo "<td>".$i->name."</td>";
        }
        echo "</tr>";
        $num=1;
        while($row=mysqli_fetch_row($res)){
            echo "<tr onclick='_click(this.id)' id='".$row[0]."'>";
            foreach($row as $k){
                echo "<td>".$k."</td>";
                if($inp==$k){
                    $temp=$row[0];
                }
            }
            $num++;
            echo "</tr>";
        }
        echo "</table>";
        $str="SELECT * FROM student WHERE id='".$inp."';";
        $res2=$mysql->query($str);
        $row1=mysqli_fetch_row($res2);

        function checkid($unchecked_id){
            $mysql=new mysqli("127.0.0.1","root","","20210415_test");
            $mysql->query("SET NAME UTF8");
            $str_check="SELECT id FROM student";
            $res_check_id=$mysql->query($str_check);
            $temp_row=Array();
            $o=0;
            while($id_row=mysqli_fetch_row($res_check_id)){
                foreach($id_row as $i){
                    $temp_row[$o]=$i;
                    $o++;
                }
            }
            foreach($temp_row as $i){
                $cc=count($temp_row)-1;
                if($i==$unchecked_id){
                    return 1;
                    break;
                }else if($i==$temp_row[$cc]){
                    return 0;
                }
            }
            print_r($res_check_id);
        }
    ?>

    <form action="msql.php" method="post">
    <br>
    <label for="search">ID :&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </label>
    <input type="text" name="search" id="search">
    <br>
    <br>
    <label for="i_name">name: </label>
    <input type="text" name="i_name" id="i_name">
    <label for="chi">&nbsp&nbspchi: </label>
    <input type="text" name="chi" id="chi">
    <label for="eng">&nbsp&nbspeng: </label>
    <input type="text" name="eng" id="eng">
    <label for="mat">&nbsp&nbspmat: </label>
    <input type="text" name="mat" id="mat">
    <br>
    <br>
    <input type="submit" value="confrim" onclick="new_page()">&nbsp&nbsp
    <input type="submit" value="insert" name='insert'>&nbsp&nbsp
    <input type="submit" value="update" name='update'>&nbsp&nbsp
    <input type="submit" value="delete" name="delete">
    </form>
    <div id="woow"></div>
    <br>
    <div>Result:</div>
    <div><?php
        echo "<table><tr>";
        foreach($row1 as $k){
            echo "<td>".$k."</td>";
        }
        echo "</tr></table>";
    ?></div>
    
    <script>
        var wow=document.getElementById("woow");
        var add=document.getElementById("add");
        var revise=document.getElementById("revise");
        var _delete=document.getElementById("delete");
        var search=document.getElementById("search");
        var tr_select=document.querySelectorAll('tr');
        console.log(count_tr);
            
        for(var o=1;o<count_tr-1;o+=2){
            tr_select[o].className="grey_tr";
            console.log(o);
        }
        function _click(id){
            search.value=id;
        }
        function new_page(){
            window.open("http://192.168.1.180/php_playground/Mysql/mysql_tab/mt.php","data selected", config='height=500, width=800');
        }
    </script>
</body>
</html>