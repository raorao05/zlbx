<?php if ($this->_var['user_info']): ?>
    ���ã�<a href="user.php" title="�û�����"><?php echo $this->_var['user_info']['username']; ?></a>����ӭ��������
<?php else: ?>
    ��<em><a href="user.php" title="��¼">��¼</a>|<a href="user.php?act=register" title="ע��">ע��</a></em>
<?php endif; ?>