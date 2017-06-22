<div class="main-content-inner" style="width:99%">
    <div class="clearfix">
        <div class="pull-right tableTools-container">
            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon" style="display: none">
                        <input type="text" placeholder="Search ..." class="nav-search-input"
                               id="nav-search-input" autocomplete="off">
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div>
        </div>
        <div class="pull-left tableTools-container">

        </div>
    </div>
    <div class="table-header"></div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <?php foreach($topRank as $date=>$info):?>
        <div id="w0" class="grid-view">
            <table class="table table-striped table-bordered table-advance table-hover">
                <thead>
                    <tr>
                        <th colspan="4" style="text-align: center;"><a href="#"><?= date('Y-m-d', strtotime($date))?>中奖名单</a></th>
                    </tr>
                    <tr>
                        <th><a href="#">排名</a></th>
                        <th><a href="#">昵称</a></th>
                        <th><a href="#">头像</a></th>
                        <th><a href="#">是否已领取</a></th>

                    </tr>
                </thead>
                <tbody>
                <?php foreach($info as $index=>$value):?>
                <tr data-key="1">
                    <td><?= $index+1;?></td>
                    <td><?= $value['nick_name'];?></td>
                    <td><img src="<?= $value['avatar'];?>" style="width: 40px;height: 40px" /></td>
                    <td><?php if($value['isHave'] == 1){
                          echo '已领取';
                        }elseif($value['isHave'] == 0){
                            echo '未领取';
                        }else{
                            echo '位置类型';
                        } ;?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <?php endforeach;?>
    </div>
</div>