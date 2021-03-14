"use strict";

(function() {

    var increaseMonth = 0;
    var increaseYear = 0;

    window.onload = function() {
        var test = document.getElementById("hello");
        //alert("help");
        test.innerHTML += " bro";    
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

    function updateDate(getCurrent = true) {
        //alert(increase);
        if(getCurrent){
            var month = dayjs().month();
            increaseMonth = month;
            var year = dayjs().year();
            increaseYear = year;

            //will need to update it to make sure that the correct date is "active"
            //var day = dayjs().date();
            //alert(day);
        }
        else{
            var month = increaseMonth;
            var year = increaseYear;
        }
        var current = document.getElementById("current-month");

        switch(month) {
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

    function addOne() {
        //alert("nice");
        //currently not going to account for years 
        increaseMonth++; 
        if(increaseMonth > 11)
        {
            increaseMonth = 0;
            increaseYear++;
        }
        updateDate(false);
    }

    function minusOne(){
        //alert("also nice");
        //currently not going to account for years
        increaseMonth--;
        if(increaseMonth < 0)
        {
            increaseMonth = 11;
            increaseYear--;
        }
        updateDate(false);
    }


})();
/*document.getElementById("calendar2").innerHTML = `
    <div class="month">
        <ul>
            <li class="prev">&#10094;</li>
            <li class="next">&#10095;</li>
            <li>March<br><span style="font-size:18px">2021</span></li>
        </ul>
    </div>

        <ul class="weekdays">
            <li>SUN</li>
            <li>MON</li>
            <li>TUE</li>
            <li>WED</li>
            <li>THU</li>
            <li>FRI</li>
            <li>SAT</li>
        </ul>
        
        <ul class="days">
            <li>01</li>
            <li>02</li>
            <li>03</li>
            <li>04</li>
            <li>05</li>
            <li>06</li>
            <li>07</li>
            <li>08</li>
            <li>09</li>
            <li>10</li>
            <li><span class="active">11</span></li>
            <li>12</li>
            <li>13</li>
            <li>14</li>
            <li>15</li>
            <li>16</li>
            <li>17</li>
            <li>18</li>
            <li>19</li>
            <li>20</li>
            <li>21</li>
            <li>22</li>
            <li>23</li>
            <li>24</li>
            <li>25</li>
            <li>26</li>
            <li>27</li>
            <li>28</li>
            <li>29</li>
            <li>30</li>
            <li>31</li>
        </ul>
`;*/
