@props(['task' => null])

<div x-data="{ task: @js($task) }" 
     class="flex items-start p-4 bg-white dark:bg-gray-800/50 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700/50 transition-all duration-300"
     :class="{ 'opacity-60': task.completed_at }">
    
    <!-- Checkbox (a lógica de submissão pode precisar de ser ajustada para Alpine mais tarde) -->
    <div class="flex-shrink-0 mt-1 mr-4">
        <form :action="`/tasks/${task.id}/complete`" method="POST">
            @csrf @method('PATCH')
            <input type="checkbox" onchange="this.form.submit()" class="..." :checked="task.completed_at">
        </form>
    </div>

    <!-- Conteúdo da Tarefa -->
    <div class="flex-grow">
        <div class="flex items-center justify-between">
            <p class="font-semibold text-lg text-gray-900 dark:text-gray-100" :class="{ 'line-through': task.completed_at }" x-text="task.title"></p>
            <div class="flex items-center space-x-2">
                <!-- Badge de Prioridade -->
                <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                      :class="{
                        'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300': task.priority === 'alta',
                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300': task.priority === 'media',
                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': task.priority === 'baixa',
                      }" x-text="task.priority.charAt(0).toUpperCase() + task.priority.slice(1)">
                </span>
                <!-- Data de Vencimento -->
                <template x-if="task.due_date">
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Vence em: <span x-text="new Date(task.due_date).toLocaleDateString('pt-PT')"></span>
                    </span>
                </template>
            </div>
        </div>
        <template x-if="task.description">
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" x-text="task.description"></p>
        </template>

        <!-- Utilizadores Atribuídos -->
        <template x-if="task.assignees && task.assignees.length > 0">
            <div class="mt-3 flex items-center space-x-2">
                <span class="text-xs font-semibold text-gray-500">Atribuído a:</span>
                <div class="flex -space-x-2">
                    <template x-for="assignee in task.assignees.slice(0, 3)" :key="assignee.id">
                        <div class="w-6 h-6 ... ring-2 ring-white dark:ring-gray-800" :title="assignee.name">
                            <span x-text="assignee.name.charAt(0).toUpperCase()"></span>
                        </div>
                    </template>
                    <template x-if="task.assignees.length > 3">
                        <div class="w-6 h-6 ... ring-2 ring-white dark:ring-gray-800">
                            <span x-text="'+' + (task.assignees.length - 3)"></span>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>

    <!-- Ações -->
    <div class="flex-shrink-0 ml-4 flex items-center space-x-2">
        <form :action="`/tasks/${task.id}`" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="text-gray-400 hover:text-red-500" title="Apagar Tarefa" onclick="return confirm('Tem a certeza?')">
                <svg ...></svg>
            </button>
        </form>
    </div>
</div>