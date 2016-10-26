<?php echo $this->fetch('pageheader.htm'); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<script type="text/javascript" src="../js/calendar.php"></script>

<link href="../js/calendar/calendar.css" rel="stylesheet" type="text/css" />

<div class="list-div" id="listDiv">

    <form name="theForm" method="post" action="weixin_egg.php?act=list&aid=<?php echo $this->_var['act']['aid']; ?>">

        <table width="100%">

            <tbody>

            <tr>

                <td class="label">活动标题 :</td>

                <td><input type="text" name="title" value="<?php echo $this->_var['act']['title']; ?>"/></td>

            </tr>

            <tr>

                <td class="label">活动介绍 :</td>

                <td><textarea name="content" rows="5" cols="40"><?php echo $this->_var['act']['content']; ?></textarea></td>

            </tr>

            <tr>

                <td class="label">是否启用 :</td>

                <td><input type="radio" name="isopen" value="1" <?php if ($this->_var['act']['isopen'] == 1): ?>checked<?php endif; ?> />开启

                    <input type="radio" name="isopen" value="0" <?php if ($this->_var['act']['isopen'] == 0): ?>checked<?php endif; ?> />关闭</td>

            </tr>

            <tr>

                <td class="label">参与次数 :</td>

                <td><input type="text" name="num" value="<?php echo $this->_var['act']['num']; ?>" /></td>

            </tr>

            <tr>

                <td class="label">活动类型 :</td>

                <td><input type="radio" name="type" value="1" <?php if ($this->_var['act']['type'] == 1): ?>checked<?php endif; ?> />每日（每天有上面的次数）

                    <input type="radio" name="type" value="2" <?php if ($this->_var['act']['type'] == 2): ?>checked<?php endif; ?> />长期（整个活动有上面的次数）</td>

            </tr>

            <?php if ($this->_var['act']['aid']): ?>

            <tr>

                <td class="label">活动地址 :</td>

                <td>/mobile/weixin/act.php?aid=<?php echo $this->_var['act']['aid']; ?></td>

            </tr>

            <?php endif; ?>

            <tr>

                <td class="label">抽奖形式 :</td>

                <td>

                    <input type="radio" name="tpl" value="1" <?php if ($this->_var['act']['tpl'] == 1): ?>checked<?php endif; ?> />砸金蛋

                    <input type="radio" name="tpl" value="2" <?php if ($this->_var['act']['tpl'] == 2): ?>checked<?php endif; ?> />刮刮卡

                    <input type="radio" name="tpl" value="3" <?php if ($this->_var['act']['tpl'] == 3): ?>checked<?php endif; ?> />大转盘

                    <!--<input type="radio" name="tpl" value="4" <?php if ($this->_var['act']['tpl'] == 4): ?>checked<?php endif; ?> />大转盘-->

                </td>

            </tr>

            <tr>

                <td class="label">活动截至时间:</td>

                <td><input type="text" name="overymd" size="25" id="overymd" value="<?php echo $this->_var['act']['overymd']; ?>"><input name="selbtn2" type="button" id="selbtn2" onclick="return showCalendar('overymd', '%Y-%m-%d ', false, false, 'selbtn2');" value="选择" class="button"/>
                </td>
            </tr>

            <tr>

                <td colspan="2" align="center">

                    <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />

                    <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />

                </td>

            </tr>

            </tbody></table>

    </form>

</div>

<?php echo $this->fetch('pagefooter.htm'); ?>