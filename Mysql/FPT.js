function Tab_Page(id){
    var i, page, btn
    page = document.getElementsByClassName('page');
    for(i=0; i<page.length; i++){
        page[i].style.display='none';
    }
    btn = document.getElementsByClassName('btn');
    for(i=0; i<btn.length; i++){
        btn[i].style.backgroundColor='';
    }
    console.log(id);
    document.getElementById(id).style.display='block';
}
document.getElementById("h").click();
