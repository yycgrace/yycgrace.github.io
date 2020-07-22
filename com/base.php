<?php
// // wdaserver (http://220.128.133.15/PMA/)
// $dsn="mysql:host=localhost;charset=utf8;dbname=s1090214";
// $pdo=new PDO($dsn,'s1090214',"s1090214");

// course Computer & yyc's NB
$dsn="mysql:host=localhost;charset=utf8;dbname=resume";
$pdo=new PDO($dsn,'root',"");


date_default_timezone_set("Asia/Taipei");
session_start();



// info(資料表,查找之id,欲印出之欄位)
function info($table,$id,$col){
    $find=find($table,['id'=>$id]);
    return $find[$col];
};




//查詢全部
function all($table,...$arg){
    global $pdo;
    $sql="select * from $table ";
    
    if(isset($arg[0]) && is_array($arg[0])){ 
        $tmp=[];
        foreach($arg[0] as $key => $value){
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql." where " . implode(" && ",$tmp);
    }

    if(isset($arg[1])){
        $sql=$sql . $arg[1];
    }

    //echo $sql;

    return $pdo->query($sql)->fetchAll();
}

//刪除資料
function del($table,$arg){
    global $pdo;
    $sql="delete from $table ";
    
    if(is_array($arg)){
        $tmp=[];
        foreach($arg as $key => $value){
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql." where " . implode(" && ",$tmp);
    }else{
        $sql=$sql." where `id`='$arg'";
    }

    echo $sql;
    return $pdo->exec($sql);
}

//查詢單筆
function find($table,$arg){
    global $pdo;

    $sql="select * from $table ";

    if(is_array($arg)){
        $tmp=[];
        foreach($arg as $key => $value){
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql." where " . implode(" && ",$tmp);
    }else{
        $sql=$sql." where `id`='$arg'";
    }

    //echo $sql;

    return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}

//計算筆數
function nums($table,...$arg){
    global $pdo;
    $sql="select count(*) from $table ";
    
    if(isset($arg[0]) && is_array($arg[0])){
        $tmp=[];
        foreach($arg[0] as $key => $value){
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql." where " . implode(" && ",$tmp);
    }

    if(isset($arg[1])){
        $sql=$sql . $arg[1];
    }

    //echo $sql;

    return $pdo->query($sql)->fetchColumn();
}

//萬用查詢
function q($sql){
    global $pdo;

    return $pdo->query($sql)->fetchAll();

}


//新增或更新資料
function save($table,$arg){
    global $pdo;
    if(isset($arg['id'])){
        //update
        foreach($arg as $key => $value){
            if($key!='id'){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
        }
    
        $sql="update $table set ".implode(',',$tmp)." where `id`='".$arg['id']."'";
    }else{
        //insert

        $sql="insert into $table (`".implode("`,`",array_keys($arg))."`) values('".implode("','",$arg)."')";
    }

    // echo $sql;
    return $pdo->exec($sql);
}

//頁面導向
function to ($url){
    header("location:".$url);
}



// test





?>