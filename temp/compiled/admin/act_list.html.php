<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="list-div" id="listDiv">
    <table width="100%" cellspacing="1" cellpadding="2" id="list-table">
        <tr>
            <th>�����</th>
            <th>�״̬</th>
            <th>��������</th>
            <th>�������</th>
            <th>�ҽ���ֹ</th>
            <th>����</th>
        </tr>
        <?php $_from = $this->_var['actList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'act');if (count($_from)):
    foreach ($_from AS $this->_var['act']):
?>
        <tr align="center">
            <td><?php echo $this->_var['act']['title']; ?></td>
            <td><?php if ($this->_var['act']['isopen'] == 1): ?>������<?php else: ?>��ֹͣ<?php endif; ?></td>
            <td><?php if ($this->_var['act']['type'] == 1): ?>ÿ��<?php else: ?>����<?php endif; ?></td>
            <td><?php echo $this->_var['act']['num']; ?></td>
            <td><?php echo $this->_var['act']['overymd']; ?></td>
            <td><a href="weixin_egg.php?act=list&aid=<?php echo $this->_var['act']['aid']; ?>"><?php echo $this->_var['lang']['edit']; ?></a> | <a href="weixin_egg.php?act=listall&aid=<?php echo $this->_var['act']['aid']; ?>">�鿴����</a> | <a href="weixin_egg.php?act=add&aid=<?php echo $this->_var['act']['aid']; ?>">��ӽ���</a></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
</div>
<?php echo $this->fetch('pagefooter.htm'); ?>