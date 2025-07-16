function changeMetier(){
    var x = document.getElementById("metier").value;
    Array.from(document.getElementsByClassName("type_metier")).forEach((element) => element.style.display='none');
    if(x!=""){
        document.getElementById(x).style.display = "block";
    }
}


function openPopup(){
    let tab = document.getElementsByClassName(document.getElementById("metier").value);
    if (tab !=null){
        Array.from(tab).forEach((element) => {
            let input = element.getElementsByTagName("input");
            if(input.type_urgence.checked){
                document.getElementById("popUp").style.display="block";
            }
        });
    }
}
