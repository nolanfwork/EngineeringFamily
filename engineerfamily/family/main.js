
    displayinitial();

function displayinitial(){
    $.ajax({
        method: "GET",
        url: "http://dataservice.accuweather.com/forecasts/v1/daily/1day/347625?apikey=A7rSDDtflJ7ZKEP2JN0PCn8rVyGK78GD&details=true"
    }).done(function(results){
        console.log(results);

        parseresult(results);
    }).fail(function(results){
        console.log("ajax request fails");
    });

}



function parseresult(results){
    $("#time").text(results.DailyForecasts[0].Date);
    $("#weather-high").text(results.DailyForecasts[0].Temperature.Maximum.Value);
    $("#weather-low").text(results.DailyForecasts[0].Temperature.Minimum.Value);
    $("#sky").text(results.DailyForecasts[0].Day.ShortPhrase);
}
$(document).ready(function(){
    $("#effect").on("click", function(e){
        $(this).fadeOut("slow");
    });
});






