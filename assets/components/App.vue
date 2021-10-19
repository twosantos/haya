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
      // get list retrieves the entities through api platform url
      getList:function(){
        let url = "https://127.0.0.1:8000/api/properties?";
        let params = [];
        params["name"] = this.search;
        params["order[" + this.sorting + "]"] = this.sortingDir;
        let lthis = this;
        this.headers.map(function(key, value) {
          if (key !== lthis.sorting) {
            params["order[" + key + "]"] = "";
          }
        });
        //parameter encoder
        const encodeGetParams = p => Object.entries(p).map(kv => kv.map(encodeURIComponent).join("=")).join("&");
        //api call
        axios.get(url+encodeGetParams(params)).then(response=>{
          this.items = response.data;
        }).catch(function(error){
          console.log('erros : ',error);
        })
      },
      // sort by determines which header is selected and how to sort
      sortBy:function(attr) {
        console.log("here");
        if (this.sorting != attr) {
          this.sortingDir = 'asc';
        } else {
          this.sortingDir = this.sortingDir == 'asc' ? 'desc' :'asc';
        }
        this.sorting = attr;
        this.getList();
      },
      // this is a custom endpoint to generate random lorem ipsum entities
      addProperties:function(){
        axios.post("https://127.0.0.1:8000/randomProperties").then(response=>{
          this.getList();
        }).catch(function(error){
          console.log('erros : ',error);
        })
      },
    },
    mounted:function(){
        this.getList();
    },
};
</script>

<style>
  .center {
    text-align: center;
  }
</style>