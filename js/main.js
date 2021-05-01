"use strict";

(function () {

    var increaseMonth = 0;
    var increaseYear = 0;

    //runs once the user loads the page
    window.onload = function () {
        //stores element that allows users to get next/prev month  
        var next = document.getElementById("next");
        var prev = document.getElementById("prev");

        //sets them to the current month & year
        updateDate();

        next.onclick = addOne;
        prev.onclick = minusOne;

        //if they click on the month -- gets them the current month (likely will change later)
        var current = document.getElementById("current-month");
        current.onclick = updateDate;
    };

    //returns the number of days in a month
    function numDaysInMonth(month, year) {
        return 32 - new Date(year, month, 32).getDate();
    }

    //creates the calendar days based on month & year
    function createCalendar(month, year) {
        //console.log(month);
        //console.log(year);
        //finds what day a month starts on
        var starting_day = (new Date(year, month)).getDay();

        //populates the calendar with dates
        var cal = document.getElementById("calendar-days");
        cal.innerHTML = ""; //clear old content

        //holds the current date
        var curr_day = dayjs().date();
        var curr_month = dayjs().month();
        var curr_year = dayjs().year();

        //holds previous month's information
        var last_month = month - 1;
        var last_month_yr = year;
        if (last_month < 0) {
            last_month = 11;
            last_month_yr--;
        }
        var backtrack = starting_day - 1; //figures how many previous days to include
        var last_month_days = numDaysInMonth(last_month, last_month_yr); //gets number of days from last month
        var counter = last_month_days - backtrack; //calculates where to start counting from

        //holds a counter for next month's days        
        var next_month_days = 1;

        //stores what date we're currently on
        var temp_date = 1;
        var id;
        for (let i = 0; i < 6; i++) {
            //creates a table row
            var temp_row = document.createElement("tr");

            //creating individual cells
            for (let j = 0; j < 7; j++) {
                //if it's before the current month starts
                if (i === 0 && j < starting_day) {
                    //creates a new cell & add the number
                    var cell = document.createElement("td");
                    var cellText = document.createTextNode(counter);
                    counter++;
                    //make the cell inactive
                    cell.classList.add("inactive");
                    //append everything together
                    cell.appendChild(cellText);
                    temp_row.appendChild(cell);
                }
                //if we've run out of days but the row isn't finished
                else if (temp_date > numDaysInMonth(month, year)) {
                    //create new cell & add the number
                    var cell = document.createElement("td");
                    var cellText = document.createTextNode(next_month_days);
                    next_month_days++;
                    //make it inactive
                    cell.classList.add("inactive");
                    //append everything together
                    cell.appendChild(cellText);
                    temp_row.appendChild(cell);
                }
                else {
                    //create new cell & add the number 
                    var cell = document.createElement("td");
                    id = ""; //will store the id for the day (currently like 04052021 but might switch to 04-05-2021)
                    id += year + "-";
                    if (month < 9) {
                        id += "0";
                    }
                    id += month + 1 + "-";
                   
                    //var circle = document.createElement("div");
                    if (temp_date < 10) {
                        var cellText = document.createTextNode("0" + temp_date);
                        id += "0";
                    }
                    else {
                        var cellText = document.createTextNode(temp_date);

                    }
                    id += temp_date;
                    var circle = document.createElement("div");
                    //if it's today's date
                    if (temp_date === curr_day && month === curr_month && year === curr_year) {
                        //console.log("in here");
                        //var circle = document.createElement("div");
                        circle.classList.add("active");
                        circle.appendChild(cellText);
                        //cell.appendChild(circle);
                        //circle.classList.add("active");
                        //cell.classList.add("active");
                    }
                    else {
                        //alert("going here");
                        //var other = document.createElement("div");
                        circle.classList.add("empty");
                        circle.appendChild(cellText);
                        //cell.appendChild(circle);
                    }

                    // if (month < 9) {
                    //     id += "0";
                    // }
                    // id += month + 1;
                    // id += year;
                    circle.setAttribute("id", id)

                    //circle.setAttribute("onClick", printID);
                    //cell.setAttribute("id", id);
                    console.log(id);
                    circle.onclick = printID; //?
                    cell.appendChild(circle);
                    temp_row.appendChild(cell);
                    temp_date++;
                }
            }
            cal.appendChild(temp_row); // appending each row into calendar body
            if (temp_date > numDaysInMonth(month, year)) {
                break;
            }

        }
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                colorMood(JSON.parse(this.responseText));
            }
        };
        xhttp.open("GET", "../php/grabmoods.php", true);
        xhttp.send();
    }

    //updates the month & year
    function updateDate(getCurrent = true) {
        // ignore date stuff -- lets just go to the new page

        // end tester
        //alert(increase);
        if (getCurrent) {
            //alert("is get current");
            var month = dayjs().month();
            increaseMonth = month;
            var year = dayjs().year();
            increaseYear = year;
            createCalendar(month, year);
        }
        else {
            var month = increaseMonth;
            var year = increaseYear;
            createCalendar(month, year);
        }
        var current = document.getElementById("current-month");

        switch (month) {
            case 0: //january
                current.innerText = "January " + year;
                break;
            case 1: //february
                current.innerText = "February " + year;
                break;
            case 2: //march
                current.innerText = "March " + year;
                break;
            case 3: //april
                current.innerText = "April " + year;
                break;
            case 4: //may
                current.innerText = "May " + year;
                break;
            case 5: //june
                current.innerText = "June " + year;
                break;
            case 6: //july
                current.innerText = "July " + year;
                break;
            case 7: //august
                current.innerText = "August " + year;
                break;
            case 8: //september
                current.innerText = "September " + year;
                break;
            case 9: //october
                current.innerText = "October " + year;
                break;
            case 10: //november
                current.innerText = "November " + year;
                break;
            default: //december
                current.innerText = "December " + year;

        }
    }

    function colorMood(moodList){
        for(var i = 0; i < moodList.length; i++){
            var currentMonth = getCurrentMonth();
            var currentYear = getCurrentYear();
            console.log(moodList[i].date);
            var y = moodList[i].date.substring(0, 4);
            console.log("Y IS " + y);
            var m = moodList[i].date.substring(5,7);
            console.log("M IS "+ m);
            if(currentMonth == m && currentYear == y){
                //console.log(moodList[i].dayQuality);
                var curr = document.getElementById(moodList[i].date);
                var classList = curr.classList;
                console.log(classList);
                var size = classList.length;
                console.log(size);
                while (size >= 0) {
                    if (classList.item(size) != "active") {
                        classList.remove(classList.item(size));
                    }
                    size--;
                }
                console.log("new class list" + classList);
                if (moodList[i].dayQuality == "good") {
                    //curr.classList.remove("empty");
                    curr.classList.add("goodDay");
                    //console.log(curr.classList);
                }
                else if (moodList[i].dayQuality == "okay") {
                    curr.classList.add("okayDay");
                }
                else if (moodList[i].dayQuality == "bad") {
                    curr.classList.add("badDay");
                }
                else {
                    console.log("you....never should have gotten here???");
                }
            }
        }
    }

    /* end erica code */

    function printID() {
        var url = "addfood.php?date=" + this.id;
        window.location.href = url;
        //window.open("../index.html");
        // // console.log()

        /*console.log("you clicked on: " + this.id);
        var num = Math.floor(Math.random() * 3);
        var curr = document.getElementById(this.id);
        console.log(num);
        //might need to remove previous classes if someone changes something for the day
        //might need to do something to differentiate what day is current day idk 
        var classList = curr.classList;
        console.log(classList);
        var size = classList.length;
        console.log(size);
        while (size >= 0) {
            if (classList.item(size) != "active") {
                classList.remove(classList.item(size));
            }
            size--;
        }
        console.log("new class list" + classList);
        if (num == 0) {
            //curr.classList.remove("empty");
            curr.classList.add("goodDay");
            //console.log(curr.classList);
        }
        else if (num == 1) {
            curr.classList.add("okayDay");
        }
        else if (num == 2) {
            curr.classList.add("badDay");
        }
        else {
            console.log("you....never should have gotten here???");
        }*/
        //var tempmonth = this.id.substring(2, 4);
        //console.log(tempmonth);
        //if(tempmonth.substring(0,1) == 0){
        //  tempmonth = tempmonth.substring(1,2);
        //}
        //console.log(tempmonth);
        //tempmonth -= 1;
        //var year = this.id.substring(4, 8);
        //console.log(year);
        //createCalendar(tempmonth, year);
        //window.open("addfood.php");
    }

    //increments the month/year counter
    function addOne() {
        //alert("nice");
        increaseMonth++;
        if (increaseMonth > 11) {
            increaseMonth = 0;
            increaseYear++;
        }
        updateDate(false);
    }

    //decrements the month/year counter
    function minusOne() {
        //alert("also nice");
        increaseMonth--;
        if (increaseMonth < 0) {
            increaseMonth = 11;
            increaseYear--;
        }
        updateDate(false);
    }

    function getCurrentMonth(){
        var curr_month = increaseMonth;
        //console.log("CURR MONTH" + curr_month);
        var m = "";
        if (curr_month < 9) {
            m += "0";
        }
        m += curr_month + 1;
        //console.log("CURR MONTH " + m);
        return m;
    }

    function getCurrentYear(){
        var curr_year = increaseYear;
        //console.log("CURR YEAR " + curr_year);
        return curr_year;
    }

})();

/*
this code is how we got the circle around the number
    var cell = document.createElement("td");
    var circle = document.createElement("div");
    circle.classList.add("hello");
    var temp_val = counter;
    var cellText = document.createTextNode(temp_val);
    cell.classList.add("inactive");
    circle.appendChild(cellText);
    cell.appendChild(circle);
    temp_row.appendChild(cell);
*/