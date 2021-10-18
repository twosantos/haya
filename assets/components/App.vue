<template>
  <div class="container">
    <h2 class="center">My Application</h2>
    <input v-model="search" placeholder="Type some text...">
    <button v-on:click="getList">Search</button>
    <button v-on:click="addProperties">Add dinamic properties</button>
    <table class="table-responsive bordered highlight centered hoverable z-depth-2">
      <thead>
        <tr>
          <th :key="header" v-for="header in headers" v-on:click="sortBy(header)">
            {{header}}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr :key="item.id" v-for="item in items">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.price }}</td>
        </tr>
      </tbody>
    </table> 
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      items: [],
      search: "",
      sorting: "",
      sortingDir: "asc",
      headers: ["id", "name", "price"]
    };
  },
  methods:{
      getList:function(){
        axios.get("https://127.0.0.1:8000/api/properties?name="+this.search).then(response=>{
          console.log(response);
          this.items = response.data;
        }).catch(function(error){
          console.log('erros : ',error);
        })
      },
      sortBy:function(attr) {
        if (this.sorting != attr) {
          this.sorting = attr;
          this.sortingDir = 'asc';
        }
        if (this.sortingDir == 'asc') {
          this.items = this.items.sort(function(a, b) {
            return a[attr] > b[attr];
          });
          this.sortingDir = 'desc';
        } else {
          this.items = this.items.sort(function(a, b) {
            return a[attr] < b[attr];
          });
          this.sortingDir = 'asc';
        }
      },
      addProperties:function(){
        axios.post("https://127.0.0.1:8000/randomProperties").then(response=>{
          this.getList();
        }).catch(function(error){
          console.log('erros : ',error);
        })
      },
    },
    mounted:function(){
        console.log("test");
        this.getList();
        console.log(this.items);
    },
};
</script>

<style>
  .center {
    text-align: center;
  }
</style>