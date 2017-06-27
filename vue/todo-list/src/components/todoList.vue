<template>
	<div class="todo-list">
		<h1 v-text="title"></h1>
		<input type="text" v-model="newItem" v-on:keyup.enter="addNewItem()">
		<ul>
			<li v-for="(item, index) in todoItems" v-bind:class="{completed: item.isCompleted}">
				<button class="finish" type="button" @click="finishItem(item)"></button>
				<label>
					{{index + 1}} . {{item.label}}
				</label>
				<button class="delete" type="button" @click="deleteItem(item)"></button>
			</li>
		</ul>
		<p class="deleteAll" @click="deleteAll">全部删除</p>
	</div>
</template>

<script>
import Storage from '../storage.js'
export default {
	name: 'todoList',
	/**
	 * 数据
	 */
	data () {
		return {
			title: 'This is a todo list',
			todoItems: Storage.fetch(),
			newItem: '',      // 与input绑定
			editedItem: null
		}
	},
	/**
	 * 方法
	 */
	methods: {
		addNewItem () {
			this.todoItems.push({
				label: this.newItem,
				isCompleted: false
			});
			this.newItem = '';		// 清空input
		},
		finishItem (item) {
			item.isCompleted = !item.isCompleted;
		},
		deleteItem (item) {
			// 从数组中删除
			this.todoItems.splice(this.todoItems.indexOf(item), 1);
		},
		deleteAll () {
			// 清空数组
			this.todoItems = [];
		}
	},
	/**
	 * 监视回调
	 */
	watch: {
		todoItems : {
			handler: function (todoItems) {
				Storage.save(todoItems);
			},
			deep: true    // 深层复制
		}
	}

}

</script>

<style scoped>
	
* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

h1 {
	font-size: 3em;
	font-weight: normal;
	line-height: 1.5;
}

input[type=text] {
	width: 100%;
	height: 36px;
	font-size: 1.5em;
}

ul {
	list-style-type: none;
}

li {
	width: 100%;
	margin:10px;
	font-size: 23px;
	text-align: left;
}

button {
	width: 25px;
	height: 25px;
	background-color: #89867e;
	margin-right: 15px;
	border-radius: 5px;
}

.todo-list {
	font-family: "Lato", Calibri, Arial, sans-serif;
	text-align: center;
	color: #89867e;
	width: 616px;
	height: 100%;
	margin: 0 auto;
}

.finish {
	float: left;
}

.delete {
	float: right;
}

.completed {
	color: #d9d9d9;
	text-decoration: line-through;
}

.deleteAll {
	margin: 1em;
	font-size: 1.2em;
	color: #d9d9d9;
	cursor: pointer;
}

.deleteAll:hover {
	color: #89867e;
}

</style>