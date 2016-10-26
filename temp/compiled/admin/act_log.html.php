<?php if ($this->_var['full_page']): ?>

<?php echo $this->fetch('pageheader.htm'); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<div class="form-div">

    <form action="javascript:searchUser()" name="searchForm">

        �������н��룺<input type="text" name="keyword" /> <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" />

    </form>

</div>

<form method="get" action="weixin_egg.php?act=log">

    <div class="list-div" id="listDiv">

        <?php endif; ?>

        <table width="100%" cellspacing="1" cellpadding="2">

            <tr>

                <th>��������</th>

                <th>�����</th>

                <th>�û��ǳ�</th>

                <th>�н�ʱ��</th>

                <th>�ҽ���ֹʱ��</th>

                <th>�н�����</th>

                <th>�Ƿ񷢽�</th>

            </tr>

            <?php $_from = $this->_var['log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>

            <tr align="center">

                <td><?php echo $this->_var['item']['class_name']; ?></td>

                <td><?php echo $this->_var['item']['title']; ?></td>

                <td><a href="users.php?act=edit&id=<?php echo $this->_var['item']['uid']; ?>"><?php echo $this->_var['item']['nickname']; ?></a></td>

                <td><?php echo $this->_var['item']['createymd']; ?></td>

                <td><?php echo $this->_var['item']['overymd']; ?></td>

                <td><?php echo $this->_var['item']['code']; ?></td>



                <td><?php if ($this->_var['item']['issend'] == 1): ?>�ѷ�<?php else: ?><a href="weixin_egg.php?act=log&lid=<?php echo $this->_var['item']['lid']; ?>&tag=send">����</a><?php endif; ?>|
                    <a href="weixin_egg.php?act=log&lid=<?php echo $this->_var['item']['lid']; ?>&tag=delete">ɾ��</a>
                </td>

            </tr>

            <?php endforeach; else: ?>

            <tr><td colspan="7">�����н���¼</td></tr>

            <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

            <tr>

                <td align="right" nowrap="true" colspan="7">

                    <?php echo $this->fetch('page.htm'); ?>

                </td>

            </tr>

        </table>

    </div>

    <?php if ($this->_var['full_page']): ?>

    </div>

</form>

<script type="text/javascript" language="JavaScript">

    listTable.recordCount = <?php echo $this->_var['record_count']; ?>;

    listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

    <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>

    listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';

    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

    listTable.query = "log";

    

    function searchUser()

    {

        listTable.filter['keywords'] = Utils.trim(document.forms['searchForm'].elements['keyword'].value);

        //listTable.filter['type'] = document.forms['searchForm'].elements['type'].value;

        listTable.filter['act'] = 'log';

        listTable.filter['page'] = 1;

        listTable.loadList();

    }

    function confirm_bath()

    {

        userItems = document.getElementsByName('checkboxes[]');



        cfm = '<?php echo $this->_var['lang']['list_remove_confirm']; ?>';



        for (i=0; userItems[i]; i++)

        {

            if (userItems[i].checked && userItems[i].notice == 1)

            {

                cfm = '<?php echo $this->_var['lang']['list_still_accounts']; ?>' + '<?php echo $this->_var['lang']['list_remove_confirm']; ?>';

                break;

            }

        }

        return confirm(cfm);

    }

</script>



<?php echo $this->fetch('pagefooter.htm'); ?>

<?php endif; ?>