<?php include_once("header.php"); ?>
<form id="form1" name="form1" method="post" action="login.php">
  <p>
    <label>
      <div align="center">Nama Pengguna</div>
    </label>
    <div align="center"></div>
    <label for="usernametxt"></label>
    <div align="center">
      <input type="text" name="usernametxt" id="usernametxt" />
    </div>

  <div align="center">Kata Laluan</div>

<div align="center">
  <input type="text" name="passwordtxt" id="passwordtxt" />
</div>
<p align="center"><br>
<input type="button" name="loginbtn" id="loginbtn" value="Masuk" onClick='window.open("menu.php","_parent")' style="
    width: 150px;" class="btn btn-success"/>
</form>
