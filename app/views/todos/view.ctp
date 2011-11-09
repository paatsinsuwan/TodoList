<div class="todos view">
<h2><?php  __('Todo');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $todo['Todo']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $todo['Todo']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($todo['User']['id'], array('controller' => 'users', 'action' => 'view', $todo['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Todo', true), array('action' => 'edit', $todo['Todo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Todo', true), array('action' => 'delete', $todo['Todo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $todo['Todo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Todos', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Todo', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
