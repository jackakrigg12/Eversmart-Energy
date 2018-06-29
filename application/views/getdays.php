<?php
if($month>0){
    $TotalNumberOfDaysInMonth = date('t', mktime(0, 0, 0, $month, 1, date('Y'))); ?>
    <div class="formitem">
        <label>What day is your Birthday?</label>
        <select name="day" id="day">
            <option value="">.. select a day ..</option>
            <?php
            for($i=1;$i<=$TotalNumberOfDaysInMonth;$i++){
                ?>
                <option value="<?=$i?>"><?=$i;?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <?php
}
else { ?>
    <div class="formitem">
        <p>Before you select a day, please select a month</p>
        <input type="hidden" name="day" id="day" value="" />
</div>
    <?php
}
?>
