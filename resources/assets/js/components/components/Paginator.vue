<template>
	<nav aria-label="Page navigation example" v-if="pagination.total > offset">
	  	<ul class="pagination pagination-sm justify-content-center">
	    	<li class="page-item" v-if="pagination.current_page">
	      		<a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
	      			<i class="fas fa-caret-left"></i>
	        		<span class="sr-only">Previous</span>
	      		</a>
	    	</li>
	    	<li v-for="page in pagesNumber" :class="[{'page-item': true}, page == isActived ? 'active' : '']">
	    		<a class="page-link" @click.prevent="changePage(page)" href="#">{{page}}</a>
	    	</li>	
	    	<li class="page-item" v-if="pagination.current_page < pagination.last_page">
	      		<a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)">
	      			<i class="fas fa-caret-right"></i>
	        		<span class="sr-only">Next</span>
	      		</a>
	    	</li>
	  	</ul>
	</nav>
</template>

<script>
	
	export default {
		
		props:['pagination', 'offset'],
		
		computed: {
			isActived() {
                return this.pagination.current_page;
            },
			pagesNumber() {
                let from = this.pagination.current_page - this.offset;
                let to = from + (this.offset * 2);
                let pagesArray = [];

                if (!this.pagination.to) {
                    return [];
                }
                if (from < 1) {
                    from = 1;
                }
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
		},

		methods:{
			changePage(page) {
				this.$emit('changepage', page)
			}
		}
	}

</script>