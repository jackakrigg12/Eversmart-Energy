<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">

    <title>Birthday</title>

    <style type="text/css">

         body {
             background-color: #333;
             color: white;
             text-align: center;
             font-family: Calibri;
         }

        #filter_wrapper, #results_table_wrapper {
            background-color: #262626;
            width: 40%;
            height: auto;
            padding: 20px;
            margin: 0 auto;
            margin-bottom: 50px;
        }

        .formitem {
            padding: 20px 0;
        }

        table {
            width: 100%;
        }


       #day_wrapper {
            clear: both;
        }

        h1 {
            margin: 35px 0;
        }

    </style>

    <script language="javascript" type="text/javascript" src="../../user_guide/_static/jquery-3.1.0.js"></script>

    <script type="text/javascript">
        <!--

        function validate() {

            var errorString = '';

            // Get name
            if (document.getElementById('name').value == "") {
                errorString = '- Please enter a name\n';
            }

            if (document.getElementById('month').value == "") {
                errorString = '- Please select a month\n';
            }

            // Get day
            if (document.getElementById('day').value == "") {
                errorString = '- Please enter a day\n';
            }


            // Do we have everything we need?
            if (errorString) {
                alert('There were problems selecting an event to manage:\n\n' + errorString + '\nPlease check and try again.');
            }
            else {

                // Lets work out the year
                var current_month = <?=date('n');?>;
                var current_day = <?=date('j');?>;

                // If the posted month is smaller than current month their latest birthday was this year
                if (document.getElementById('month').value < current_month) {
                    var year = '<?=date('Y');?>';
                }
                // If it was this month (before today) it was this year
                else if (document.getElementById('month').value == current_month && document.getElementById('day').value < current_day) {
                    var year = '<?=date('Y');?>';
                }
                // Otherwise it must have been last year
                else {
                    var year = '<?=date("Y", strtotime("-1 year"));?>'
                }


                $.ajax({
                    type : 'POST',
                    data:{
                        name : document.getElementById('name').value,
                        month : document.getElementById('month').value,
                        day : document.getElementById('day').value,
                        year : year
                    },
                    url: "http://localhost/codeigniter/index.php/birthday/api_call",
                    success : function(data){
                        jQuery("div#results_wrapper").html(data);
                    }
                });

            }

        }

        function loadDays(month){
            $.ajax({
                type : 'POST',
                data:{ month:month},
                url: "http://localhost/codeigniter/index.php/birthday/getdays",
                success : function(data){
                    jQuery("div#day_wrapper").html(data);
                }
            });
        }

        -->
    </script>

</head>
<body>

<div id="container">
    <h1>Jack Akrigg - Tech Test</h1>
<p>What was the EUR to GBP exchange rate on your previous Birthday?</p>
    <table id="body">

        <div id="filter_wrapper">

            <input type="hidden" name="year" id="year" value="" />

            <div class="formitem">
                <label>Name</label>
                <input type="text" id="name" name="name" value="" />
            </div>

            <div class="clearfix"></div>

            <div class="formitem">
                <label>What month is your Birthday?</label>
                <select name="month" id="month" onchange="loadDays(this.value)">
                    <option value="">.. select a month ..</option>
                    <?php
                    for($i=1;$i<=12;$i++){
                        $MonthName = date('F', mktime(0, 0, 0, $i, 1));
                        ?>
                        <option value="<?=$i?>"><?=$MonthName;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="clearfix"></div>

            <div id="day_wrapper"></div>

            <div class="clearfix"></div>

            <div class="formitem">
                <input type="button" name="submit_btn" id="submit_btn" value="Submit" onclick="validate();">
            </div>

        </div>


        <div id="results_wrapper"></div>


    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>







