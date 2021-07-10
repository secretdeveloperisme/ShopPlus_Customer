<?php
  session_start();
  if(isset($_POST["action"]) && !empty($_POST["action"])){
    $status = array("status"=>"error");
    if($_POST["action"] == "setSession"){
      if(isset($_POST["content"]) && !empty($_POST["content"])){
        if($_SESSION["customer"] = $_POST["content"])
          $status = array("status"=>"success");
      }
    }
    if($_POST["action"] == "getSession"){
      if(isset($_SESSION["customer"])){
        $status = array("status"=>"success","content"=>$_SESSION["customer"]);
      }
    }
    echo json_encode($status);
  }
