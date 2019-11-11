<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-xs-12" >
        <table class="table">
            <thead>
                <tr>
                    <th>Source</th>
                    <th>Jumlah Data</th>
                    <th>Jumlah Data Training</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $jd = 0;
                $js = 0;
                foreach ($json as $a => $b) :
                    $i=0;
                    foreach ($b as $c => $d){
                        $i = $i + sizeof($d);
                    }
                    $jd += $i;
                    $js += 80;
            ?>
                <tr>
                    <td><?= $a; ?></td>
                    <td><?= $i; ?></td>
                    <td><?= "80"; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th><?= $jd; ?></th>
                    <th><?= $js; ?></th>
                </tr>
            </tfoot>
        </table>
        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th>Merk</th>
                    <th>Source</th>
                    <th>Jumlah Data</th>
                    <th>Jumlah Data Training</th>
                </tr>
            </thead>
            <tbody>
            <?php

                $jd = 0;
                $js = 0;
                foreach ($json['twitter'] as $a => $b) :
                    $i=0;
                    $jd += sizeof($json['twitter'][$a]) + sizeof($json['seluar.id'][$a]);
                    $js += 16 + 16;
                    
            ?>
                <tr>
                    <td rowspan="2"><?= $a; ?></td>
                    <td><?= "Twitter"; ?></td>
                    <td><?= sizeof($json['twitter'][$a]); ?></td>
                    <td>16</td>
                </tr>
                <tr>    
                    <td><?= "Selular.id"; ?></td>
                    <td><?= sizeof($json['seluar.id'][$a]); ?></td>
                    <td>16</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th><?= $jd; ?></th>
                    <th><?= $js; ?></th>
                </tr>
            </tfoot>
        </table> 
    </div>

    <div class="col-xs-4 text-center" style="padding-top:100px;">
    </div>
    <div class="col-xs-8" style="padding-top:120px;">
    </div>
</div>
