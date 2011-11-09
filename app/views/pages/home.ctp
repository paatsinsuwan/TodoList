<h2>My Todo List</h2>
<ul id="todolist">
	<li>
		<?php echo $this->Form->create('Todo', array('action' => 'add')); ?>
		<?php echo $this->Form->input('title', array('label' => '', 'value' => 'Enter New Todo item', 'class' => 'newItem')); ?>
		<?php echo $this->Form->end(); ?>
	</li>
	<?php foreach($todos as $todo): ?>
		<li class="list">
			<?php
				$todoId = $todo['Todo']['id'];
				if($todo['Todo']['done']){
				 	$span = "<span class='done' alt='$todoId'>".$todo['Todo']['title']."</span>";
				}
				else{
					$span = "<span alt='$todoId'>".$todo['Todo']['title']."</span>";
				}
				echo $this->Form->checkbox('todo', array('id' => 'todo_'.$todo['Todo']['id'], 'class' => 'mark', 'checked' => (!empty($todo['Todo']['done'])?'checked':''))).(!empty($span)?$span:$todo['Todo']['title']); 
				unset($span);
			?>
			<?php echo $this->Html->image('close_button.png', array('width' => 21, 'height' => 21, 'url' => '/todos/delete/'.$todo['Todo']['id'])); ?>
		</li>
	<?php endforeach; ?>
</ul>
<ul id="helper">
	<li>Double click a todo to edit name of thing to do.</li>
</ul>