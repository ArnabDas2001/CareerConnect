<!-- php -->

<?php 
session_start();
    require '../../dbconnect.php';

    if(isset($_POST["apply"])){
        $internship_id = $_GET["id"];
        $internship_topic = $_POST["hidden_topic"];
        $internship_location = $_POST["hidden_location"];
        $internship_duration = $_POST["hidden_duration"];
     
        $sql = "INSERT INTO `applied` (`profile`, `location`, `duration`) VALUES ('$internship_topic', '$internship_location', '$internship_duration');";
        mysqli_query($conn, $sql);
        header("Location:../Internship/apply.php");
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship/Job</title>
    <link rel="stylesheet" href="../../style.css?v=<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/0d6185a30c.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <!-- navbar -->
    <header>
        <nav id="navbar">
            <div class="container">
                <div class="logo">CareerConnect</div>
                <ul class="nav-links">
                    <li id="button1" class="interJobbutton" onclick="toggleCard(1)"><a href="#">Internship</a></li>
                    <li id="button2" class="interJobbutton" onclick="toggleCard(2)"><a href="#">Job</a></li>
                    <li><a href="../internship/applied.php"><i class="fas fa-bookmark"></i></a></li>
                    <li><a href="#"><i class="fas fa-message"></i></a></li>
                    <li><a href="#"><i class="fas fa-user"></i></a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- internship page -->
    <div class="internshipPage" id="card1">
    <div class="internshipSection">

    <!-- filter section -->
    <div class="filterContainer">
      <div class="filter">
        <i class="fas fa-filter">
            <h1>Filters</h1>
        </i>
      </div>
       
      <div class="filterOptions">

        <!-- checkbox -->
        <label class="container">As per my preferences
            <input type="checkbox"  id="myCheckbox" onchange="toggleInput()">
            <span class="checkmark"></span>
        </label>
        <label class="container containerWfrmH">Work from home
            <input type="checkbox" id="option5Input" onchange="toggleInput()">
            <span class="checkmark"></span>
        </label>
        <label class="container containerPartTime">Part-time
            <input type="checkbox" id="option6Input">
            <span class="checkmark"></span>
        </label>
        <label class="container containerjobOff">Internships with job offer
            <input type="checkbox" id="option7Input">
            <span class="checkmark"></span>
        </label>

        <!-- inputbox -->
        <label class="inputBox">
            <p>Profile</p>
            <input type="text" placeholder="e.g. Web Development" id="option1Input">
        </label>
        <label class="inputBox inputBoxlocation">
            <p>Location</p>
            <input type="text" placeholder="e.g. Delhi" id="option2Input">
        </label>
        <label class="inputBox inputBoxDate">
            <p>Starting from (or after)</p>
            <input type="date" placeholder="Choose Date" id="option3Input">
        </label>
        <label class="inputBox inputBoxDuration">
            <p>Max.duration(months)</p>
            <div class="dropdown">
                <input type="text" id="option4Input" onclick="showDropdown()" placeholder="Choose Duration">
                <div class="dropdown-content" id="dropdownOptions">
                  <a href="#" onclick="selectOption('1 month')">1 month</a>
                  <a href="#" onclick="selectOption('2 months')">2 months</a>
                  <a href="#" onclick="selectOption('3 months')">3 months</a>
                  <a href="#" onclick="selectOption('4 months')">4 months</a>
                  <a href="#" onclick="selectOption('5 months')">5 months</a>
                  <a href="#" onclick="selectOption('6 months')">6 months</a>
                </div>
              </div>
        </label>

      </div>
    </div>

    <!-- Internship listings -->
    <div class="internshipContainer">
        <h2>
         821 Total  internships
        </h2>

        <div class="internshipOrder">
            <?php

            $query = "SELECT * FROM `internships` ORDER BY id ASC";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){

            ?>
            <div class="internshipCard internshipCard1">

            <form action="Internship.php?action=add&id=<?php echo $row["id"]?>" method="POST">
                <h1>  <?php echo $row["topic"]; ?>  </h1>
                <div class="locationP">
                <i class="fa-solid fa-location-dot"></i> 

                <?php echo $row["work_location"]; ?> 
                <?php echo $row["location_name"]; ?>

                </div>
                <div class="mainDetails">
                    <div class="lastDateapply">
                        <p><i class="fa-solid fa-calendar-days"></i>  Last date to apply</p>
                        <p> <?php echo $row["apply_by"]; ?> </p>
                    </div>
                    <div class="durationInternship">
                        <p><i class="fa-solid fa-clock"></i>  Duration</p>
                        <p> <?php echo $row["duration"]; ?> </p>
                    </div>
                    <div class="stipendInternship">
                        <p><i class="fa-solid fa-sack-dollar"></i>  Stipend</p>
                        <p>&#8377; <?php echo $row["stipend"]; ?> /month</p>
                    </div>
                </div>

                <input type="hidden" name="hidden_topic" value="<?php echo $row["topic"]; ?>">
                <input type="hidden" name="hidden_location" value="<?php echo $row["work_location"] . ' ' . $row["location_name"]; ?>">
                <input type="hidden" name="hidden_duration" value="<?php echo $row["duration"]; ?>">
                

                <div class="buttonNextstep">
                    <div class="details"><button>View Details</button></div>
                   <button class="applyButton" type="submit" name="apply">Apply</button>
                </div>
                </form>
            </div>
            <?php

                }
            }
            ?>
        </div>

        <h3>
            1/206
        </h3>
    </div>

    </div>
 </div>


  <!-- job page -->
  <div class="jobPage" id="card2">
    <div class="internshipSection">

    <!-- filter section -->
    <div class="filterContainer">
      <div class="filter">
        <i class="fas fa-filter">
            <h1>Filters</h1>
        </i>
      </div>
       
      <div class="filterOptions">

        <!-- checkbox -->
        <label class="container">As per my preferences
            <input type="checkbox"  id="myCheckboxjob" onchange="toggleInputjob()">
            <span class="checkmark"></span>
        </label>
        <label class="container containerWfrmH">Work from home
            <input type="checkbox" id="option5Inputjob" onchange="toggleInputjob()">
            <span class="checkmark"></span>
        </label>
        <label class="container containerPartTime">Part-time
            <input type="checkbox" id="option6Inputjob">
            <span class="checkmark"></span>
        </label>

        <!-- inputbox -->
        <label class="inputBox">
            <p>Profile</p>
            <input type="text" placeholder="e.g. Web Development" id="option1Inputjob">
        </label>
        <label class="inputBox inputBoxlocation">
            <p>Location</p>
            <input type="text" placeholder="e.g. Delhi" id="option2Inputjob">
        </label>
        <label class="inputBox inputBoxDate">
            <p>Starting from (or after)</p>
            <input type="date" placeholder="Choose Date" id="option3Inputjob">
        </label>
        <label class="inputBox inputBoxDuration">
            <p>Years of experience</p>
            <div class="dropdown">
                <input type="text" id="option4Inputjob" onclick="showDropdown()" placeholder="Select years of experience">
                <div class="dropdown-content" id="dropdownoptionsJob">
                  <a href="#" onclick="selectOption('freser')">Fresher</a>
                  <a href="#" onclick="selectOption('1 year')">1 year</a>
                  <a href="#" onclick="selectOption('2 years')">2 years</a>
                  <a href="#" onclick="selectOption('3 years')">3 years</a>
                  <a href="#" onclick="selectOption('4 years')">4 years</a>
                  <a href="#" onclick="selectOption('5 years')">5 years</a>
                  <a href="#" onclick="selectOption('5+ years')">5+ years</a>
                </div>
              </div>
        </label>

      </div>
    </div>

    <!-- Internship listings -->
    <div class="internshipContainer">
        <h2>
         643 Total  jobs
        </h2>

        <div class="internshipOrder">
            <div class="internshipCard internshipCard1"></div>
            <div class="internshipCard internshipCard2"></div>
            <div class="internshipCard internshipCard3"></div>
            <div class="internshipCard internshipCard4"></div>
        </div>

        <h3>
            1/206
        </h3>
    </div>

    </div>
 </div>

    <!-- <footer>

    </footer> -->



    <script src="../../javaScripts/dropdown.js"></script>
    <script src="../../javaScripts/inputDisable.js"></script>
    <script src="../../javaScripts/switchState.js"></script>
    <script src="../../javaScripts/buttonSwitch.js"></script>
</body>
</html>