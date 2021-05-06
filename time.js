function display_c() {
  var refresh=1000; // Refresh rate in milli seconds
  mytime=setTimeout('display_ct()',refresh);
}

function display_ct() {

  var MyDate = new Date();
  var MyDateString;
  MyDate.setDate(MyDate.getDate());

  MyDateString = ('0' + MyDate.getDate()).slice(-2) + '/'
    + ('0' + (MyDate.getMonth()+1)).slice(-2) + '/'
    + MyDate.getFullYear() + ' '
    + ('0' + MyDate.getHours()).slice(-2) + ':'
    + ('0' + MyDate.getMinutes()).slice(-2) + ':'
    + ('0' + MyDate.getSeconds()).slice(-2);
  document.getElementById('ct').innerHTML = MyDateString;
  display_c();

}
