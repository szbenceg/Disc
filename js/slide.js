
var steppNumber = 2;

var currentIds = [];

currentIds["pop"] = 0;
currentIds["rock"] = 0;
currentIds["hip-hop"] = 0;
currentIds["electronic"] = 0;
currentIds["classical"] = 0;
currentIds["country"] = 0;

var slideLengths = [];

slideLengths["pop"] = 0;
slideLengths["rock"] = 0;
slideLengths["hip-hop"] = 0;
slideLengths["electronic"] = 0;
slideLengths["classical"] = 0;
slideLengths["country"] = 0;

if($(".vinyls-container").width() < 480){
    steppNumber = 2;
}else if($(".vinyls-container").width() < 650){
    steppNumber = 3;
}else if($(".vinyls-container").width() < 830){
    steppNumber = 4;
}else if($(".vinyls-container").width() < 990){
    steppNumber = 5;
}else if($(".vinyls-container").width() < 1180){
    steppNumber = 6;
}else if($(".vinyls-container").width() < 1350){
    steppNumber = 7;
}else if($(".vinyls-container").width() < 1530){
    steppNumber = 8;
}else if($(".vinyls-container").width() < 1690){
    steppNumber = 9;
}else{
    steppNumber = 10;
}


function scrollToElem(type){
    $("#" + type + "-vinyls-container").animate({
        scrollLeft: $("#DM" + type + currentIds[type]).position().left + $("#" + type + "-vinyls-container").scrollLeft()
    }, 1000);
}

function currentDiscId(direction, type){

    if(direction == "right"){

        if(currentIds[type] >= (slideLengths[type]-1)){
            return false;
        }

        if((currentIds[type] + steppNumber) > slideLengths[type]){

            currentIds[type] = (slideLengths[type]-1);            
            return true;

        }else{

            currentIds[type] += steppNumber;
            return true;

        }

    }else if(direction == "left"){


        if(currentIds[type] == 0){
            return false;
        }

        if(currentIds[type] - steppNumber >= 0){

            currentIds[type] -= steppNumber;
            return true;

        }else{
            currentIds[type] = 0;
            return true;
        }
        
    }
}

$(".right-arrow").click(function(){
    if(currentDiscId("right", $(this).attr("id"))){
        scrollToElem($(this).attr("id"));
    }
});

$(".left-arrow").click(function(){
    if(currentDiscId("left", $(this).attr("id"))){
        scrollToElem($(this).attr("id"));
    }
});

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

$.ajax({
    url: "ajaxrequest.php",
    method: "POST",
    data: {
        requestType: "getDiscs"
    },
    dataType: "json",
    success:function(data){

        slideLengths["pop"] = data.pop.length;
        slideLengths["rock"] = data.rock.length;
        slideLengths["hip-hop"] = data.hipHop.length;
        slideLengths["electronic"] = data.electronical.length;
        slideLengths["classical"] = data.classical.length;
        slideLengths["country"] = data.country.length;

        if(getUrlVars()["location"] == "specGenre" && getUrlVars()["genre"] == "pop"){
            for(var i=0; i<data.pop.length; i++){
                $("#genre-vinyls-container").append(
                    "<div id='DMpop" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.pop[i].discId +"><img class='vinyl-image' src='vinyls/" + data.pop[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+ data.pop[i].album +"</div>" +
                    "</div>"
                );
            }
        }

        if(getUrlVars()["location"] == "specGenre" && getUrlVars()["genre"] == "rock"){
            for(var i=0; i<data.rock.length; i++){
                $("#genre-vinyls-container").append(
                    "<div id='DMrock" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.rock[i].discId + "><img class='vinyl-image' src='vinyls/" + data.rock[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+ data.rock[i].album + "</div>" +
                    "</div>"
                );
            }
        }

        if(getUrlVars()["location"] == "specGenre" && getUrlVars()["genre"] == "hip-hop"){
            for(var i=0; i<data.hipHop.length; i++){
                $("#genre-vinyls-container").append(
                    "<div id='DMhip-hop" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.hipHop[i].discId +"><img class='vinyl-image' src='vinyls/" + data.hipHop[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+data.hipHop[i].album+"</div>" +
                    "</div>"
                );
            }
        }

        if(getUrlVars()["location"] == "specGenre" && getUrlVars()["genre"] == "electronical"){
            for(var i=0; i<data.electronical.length; i++){
                $("#genre-vinyls-container").append(
                    "<div id='DMelectronic" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.electronical[i].discId +"><img class='vinyl-image' src='vinyls/" + data.electronical[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+data.electronical[i].album+"</div>" +
                    "</div>"
                );
            }
        }

        if(getUrlVars()["location"] == "specGenre" && getUrlVars()["genre"] == "classical"){
            for(var i=0; i<data.classical.length; i++){
                $("#genre-vinyls-container").append(
                    "<div id='DMclassical" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.classical[i].discId +"><img class='vinyl-image' src='vinyls/" + data.classical[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+data.classical[i].album+"</div>" +
                    "</div>"
                );
            }
        }

        if(getUrlVars()["location"] == "specGenre" && getUrlVars()["genre"] == "country"){
            for(var i=0; i<data.country.length; i++){
                $("#genre-vinyls-container").append(
                    "<div id='DMcountry" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.country[i].discId +"><img class='vinyl-image' src='vinyls/" + data.country[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+data.country[i].album+"</div>" +
                    "</div>"
                );
            }
        }



        if(getUrlVars()["location"] != "specGenre"){
            for(var i=0; i<data.pop.length; i++){
                $("#pop-vinyls-container").append(
                    "<div id='DMpop" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.pop[i].discId +"><img class='vinyl-image' src='vinyls/" + data.pop[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+ data.pop[i].album +"</div>" +
                    "</div>"
                );
            }

            for(var i=0; i<data.rock.length; i++){
                $("#rock-vinyls-container").append(
                    "<div id='DMrock" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.rock[i].discId + "><img class='vinyl-image' src='vinyls/" + data.rock[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+ data.rock[i].album + "</div>" +
                    "</div>"
                );
            }

            for(var i=0; i<data.hipHop.length; i++){
                $("#hip-hop-vinyls-container").append(
                    "<div id='DMhip-hop" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.hipHop[i].discId +"><img class='vinyl-image' src='vinyls/" + data.hipHop[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+data.hipHop[i].album+"</div>" +
                    "</div>"
                );
            }

            for(var i=0; i<data.electronical.length; i++){
                $("#electronic-vinyls-container").append(
                    "<div id='DMelectronic" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.electronical[i].discId +"><img class='vinyl-image' src='vinyls/" + data.electronical[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+data.electronical[i].album+"</div>" +
                    "</div>"
                );
            }

            for(var i=0; i<data.classical.length; i++){
                $("#classical-vinyls-container").append(
                    "<div id='DMclassical" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.classical[i].discId +"><img class='vinyl-image' src='vinyls/" + data.classical[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+data.classical[i].album+"</div>" +
                    "</div>"
                );
            }

            for(var i=0; i<data.country.length; i++){
                $("#country-vinyls-container").append(
                    "<div id='DMcountry" + i + "' class='image-container'>" +
                        "<a href=index.php?location=specs&discId="+ data.country[i].discId +"><img class='vinyl-image' src='vinyls/" + data.country[i].discId + ".jpg'></a>" +
                        "<div class='image-description'>"+data.country[i].album+"</div>" +
                    "</div>"
                );
            }
        }

    },
    error:function(error){
        console.log(error.responseText);
    }
});