
<div id="results_table_wrapper">
    <h2>Results</h2>

    <table>

        <thead style="margin-bottom: 10px">
            <th>Name</th>
            <th>Birthday</th>
            <th>Exchange rate</th>
            <th>Date</th>
        </thead>

        <?php  $birthday = new Birthday();
        $result_set = $birthday->find_all_valid_birthdays();

        foreach ($result_set as $row) { ?>

            <tr>
                <td><?php echo $row->name;?></td>
                <td><?php echo date('d/m/Y',$row->birthday);?></td>
                <td><?php echo $row->exchange_rate;?></td>
                <td><?php echo date('d/m/Y H:i',$row->insert_date);?></td>
            </tr>
            <?php

        }
        ?>
    </table>
</div>
