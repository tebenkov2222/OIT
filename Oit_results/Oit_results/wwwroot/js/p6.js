let hourBegin;
let weatherData;
let timeRow;
let tableRows;
let oldTable;

function initTable()
{
    let table = document.querySelector('.weather');
    timeRow = table.rows[0];
    tableRows = table.rows;
}
function changeCity()
{
    let city = document.querySelector('.cities_list').value;
    localStorage.setItem("city_chosen", city);
    getWeatherData(city);
}

function getSavedData()
{
    let citySaved = localStorage.getItem("city_chosen");
    if(citySaved == null || citySaved == undefined)
        citySaved = '0';
    document.querySelector('.cities_list').value = citySaved;
    getWeatherData(citySaved);
}

async function getWeatherData(city)
{
    displayLoading();
    let isSuccess = false;
    let response;
    try {
        switch (city)
        {
            case '0':
                response = await fetch("https://www.7timer.info/bin/civil.php?lon=53.2324&lat=56.8619&output=json");
                break;
            case '1':
                response = await fetch("https://www.7timer.info/bin/civil.php?lon=139.6503&lat=35.6762&output=json");
                break;
            case '2':
                response = await fetch("https://www.7timer.info/bin/civil.php?lon=12.3155&lat=45.4408&output=json");
                break;
            default:
                response = await fetch("https://www.7timer.info/bin/civil.php?lon=53.2324&lat=56.8619&output=json");
                break;
        }
        weatherData = await response.json();
        hourBegin = weatherData.init.substring(8);
        displayTable();
        initTable();
        parseAllData();
    }
    catch (e)
    {
        displayError(e);
    }
}

function displayTable()
{
    let tableBlank = document.querySelector('.weather_blank');
    if(oldTable)
        oldTable.remove();
    oldTable = tableBlank.cloneNode(true);
    oldTable.className = 'weather';
    tableBlank.parentNode.appendChild(oldTable);
    document.querySelector('.weather').style.display = 'table';
    document.querySelector('.loading').style.display = 'none';
    document.querySelector('.error').style.display = 'none';
    document.querySelector('.cities').style.display = 'block';
    document.querySelector('.cities_list').style.display = 'block';
}

function displayError(response)
{
    document.querySelector('.weather').style.display = 'none';
    document.querySelector('.loading').style.display = 'none';
    document.querySelector('.cities').style.display = 'none';
    document.querySelector('.cities_list').style.display = 'none';
    document.querySelector('.error').style.display = 'block';
    document.querySelector('.error').innerText = "Возникла непредвиденная ошибка: " + response;
}

function displayLoading()
{
    var weatherTable = document.querySelector('.weather');
    if(weatherTable != null)
        weatherTable.style.display = 'none';
    document.querySelector('.loading').style.display = 'block';
    document.querySelector('.cities').style.display = 'none';
    document.querySelector('.cities_list').style.display = 'none';
    document.querySelector('.error').style.display = 'none';
}

function parseAllData()
{
    let currentTime = 0;
    let skipCount = 1 + Math.floor(parseInt(hourBegin) / 3);
    let dayIndex = 1;
    let isFullDay = false;
    let changeDayFlag = false;
    weatherData.dataseries.forEach((data)=>
    {
        let temp = "";
        let moist = "";
        if(skipCount <= 0)
        {
            temp = data.temp2m + "°C";
            moist = data.rh2m;
        }
        skipCount--;

        let oldTime = currentTime;
        currentTime = currentTime + 3;
        if(changeDayFlag)
        {
            dayIndex++;
            changeDayFlag = false;
        }
        if(currentTime >= 24)
        {
            changeDayFlag = true;
            currentTime -= 24;
        }

        let prettyPrintCurrentTime = currentTime;
        if(prettyPrintCurrentTime < 10)
            prettyPrintCurrentTime = "0" + prettyPrintCurrentTime;
        let prettyPrintOldTime = oldTime;
        if(prettyPrintOldTime < 10)
            prettyPrintOldTime = "0" + prettyPrintOldTime;

        if(dayIndex == 2)
            isFullDay = true;
        if(dayIndex <= 3)
        {
            const timeStamp = prettyPrintOldTime + "-" + prettyPrintCurrentTime;
            let weather = "";
            if(temp != "")
                weather = temp + "/" + moist;
            addToTable(weather, timeStamp, dayIndex, isFullDay)
        }
    })
}

function addToTable(weather, timeStamp, dayIndex, isFullDay)
{
    if(!isFullDay)
    {
        let newTimeCell = timeRow.insertCell();
        newTimeCell.innerText = timeStamp;
    }
    let newWeatherCell = tableRows[dayIndex].insertCell();
    newWeatherCell.innerText = weather;
}

function generateTable(table) {

    for (let key of data) {
        let th = document.createElement("th");
        let text = document.createTextNode(key);
        th.appendChild(text);
        row.appendChild(th);
    }
}
