document.onreadystatechange = function(){
    var labels = document.getElementsByTagName("label");
    for (var i = 0; i < labels.length; i++){
        if(labels[i].classList.contains("label"))
            continue;

        labels[i].classList.add("label")
    }

    var inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++){
        if(inputs[i].type == "checkbox")
            continue;

        if(inputs[i].classList.contains("input"))
            continue;

        inputs[i].classList.add("input");
    }

    var buttons = document.getElementsByTagName("button")
}