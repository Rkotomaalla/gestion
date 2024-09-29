export function insert_rubrique(){
    // obtention des donnees
    var rubrique_name=document.getElementById("rubrique_name").value;
    var rubrique_unite=document.getElementById("rubrique_unite").value;
    
    // ajout des donnees dans un formdata
    var formdata=new FormData();
    formdata.append("name",rubrique_name);
    formdata.append("unite",rubrique_unite);
    this.insert_data(formdata,"save_rubrique.php");

}
// focntion insert rehetra==============================================================
function insert_data(formdata,php_url){
    // instantiationn de xhr
    var xhr;
    try{
        xhr=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e){
        try{
            xhr=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch(e){
            try{
            xhr=new XMLHttpRequest();
            }
            catch(e2){
                xhr=false
            }
        }
    }
    // ====
    xhr.onreadystatechange=function(){
        if(xhr.readyState==4){
                if(xhr.status==200){
                    var response=JSON.parse(xhr.responseText);
                }else{
                    document.dyn="Error code"+xhr.status
                }
        }
    };
    xhr.open("POST",php_url,true);
    xhr.send(formdata)
}