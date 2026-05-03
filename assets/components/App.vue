<template>
  <div id="app-container">
    <header class="app-header">
      <h1>Property Listings</h1>
      <p>Browse and manage your properties with ease</p>
    </header>

    <div class="toolbar">
      <input type="text" v-model="search" placeholder="Search by name..." @keyup.enter="getList" class="search-input">
      <button @click="getList" class="btn-primary">Search</button>
      <button @click="showAddModal = true" class="btn-primary">Add Property</button>
      <button @click="addProperties" class="btn-secondary">Add Random Properties</button>
    </div>

    <div class="table-container">
      <table class="property-table">
        <thead>
          <tr>
            <th v-for="header in headers" :key="header" @click="sortBy(header)" class="sortable">
              {{ header.toUpperCase() }}
              <span v-if="sorting === header">{{ sortingDir === 'asc' ? '▲' : '▼' }}</span>
            </th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in items" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>${{ item.price.toLocaleString() }}</td>
            <td class="actions">
              <button @click="openEditModal(item)" class="btn-primary">Edit</button>
              <button @click="deleteProperty(item.id)" class="btn-danger">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Add Property Modal -->
    <div v-if="showAddModal" class="modal-overlay">
      <div class="modal-content">
        <h2>Add New Property</h2>
        <form @submit.prevent="saveProperty">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" v-model="newProperty.name" required>
          </div>
          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" v-model="newProperty.price" required>
          </div>
          <div class="modal-actions">
            <button type="submit" class="btn-primary">Save</button>
            <button type="button" @click="showAddModal = false" class="btn-secondary">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Property Modal -->
    <div v-if="showEditModal" class="modal-overlay">
      <div class="modal-content">
        <h2>Edit Property</h2>
        <form @submit.prevent="updateProperty">
          <div class="form-group">
            <label for="edit-name">Name</label>
            <input type="text" id="edit-name" v-model="editingProperty.name" required>
          </div>
          <div class="form-group">
            <label for="edit-price">Price</label>
            <input type="number" id="edit-price" v-model="editingProperty.price" required>
          </div>
          <div class="modal-actions">
            <button type="submit" class="btn-primary">Update</button>
            <button type="button" @click="showEditModal = false" class="btn-secondary">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      items: [],
      search: "",
      sorting: "id",
      sortingDir: "asc",
      headers: ["id", "name", "price"],
      showAddModal: false,
      showEditModal: false,
      newProperty: {
        name: '',
        price: 0
      },
      editingProperty: null
    };
  },
  methods: {
    getList() {
      const url = "/api/properties";
      const params = {};

      if (this.search) {
        params.name = this.search;
      }

      if (this.sorting) {
        params[`order[${this.sorting}]`] = this.sortingDir;
      }

      axios.get(url, { params })
        .then(response => {
          this.items = response.data.member || response.data;
        })
        .catch(error => {
          console.error('API Error:', error);
        });
    },

    sortBy(attr) {
      if (this.sorting === attr) {
        this.sortingDir = this.sortingDir === 'asc' ? 'desc' : 'asc';
      } else {
        this.sorting = attr;
        this.sortingDir = 'asc';
      }
      this.getList();
    },

    addProperties() {
      axios.post("/randomProperties")
        .then(() => {
          this.getList();
        })
        .catch(error => {
          console.error('API Error:', error);
        });
    },

    saveProperty() {
      axios.post('/api/properties', this.newProperty, {
        headers: {
          'Content-Type': 'application/ld+json'
        }
      })
        .then(() => {
          this.showAddModal = false;
          this.newProperty = { name: '', price: 0 };
          this.getList();
        })
        .catch(error => {
          console.error('API Error:', error);
        });
    },

    openEditModal(item) {
      this.editingProperty = { ...item };
      this.showEditModal = true;
    },

    updateProperty() {
      axios.patch(`/api/properties/${this.editingProperty.id}`, this.editingProperty, {
        headers: {
          'Content-Type': 'application/merge-patch+json'
        }
      })
        .then(() => {
          this.showEditModal = false;
          this.getList();
        })
        .catch(error => {
          console.error('API Error:', error);
        });
    },

    deleteProperty(id) {
      if (confirm('Are you sure you want to delete this property?')) {
        axios.delete(`/api/properties/${id}`)
          .then(() => {
            this.getList();
          })
          .catch(error => {
            console.error('API Error:', error);
          });
      }
    }
  },
  mounted() {
    this.getList();
  },
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 2rem;
  border-radius: 8px;
  width: 400px;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
}

.form-group input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 2rem;
}

.actions {
  display: flex;
  gap: 0.5rem;
}

.btn-danger {
  background-color: #dc3545;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
}
</style>
