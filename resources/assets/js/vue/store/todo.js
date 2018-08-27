import Vue from 'vue';
import Vuex from 'vuex';

import TodosApi from '../../TodosApi';

Vue.use(Vuex);


const store = new Vuex.Store({
  state: {
    items: []
  },
  mutations: {
    addItem (state, item) {
      state.items.unshift(item);
    },
    setItems (state, items) {
      state.items = items;
    },
    updateItem(state, item) {
      const index = state.items.indexOf(item);

      if (index < 0) {
        return;
      }

      state.items[index] = item;
    },
    deleteItem(state, item) {
      const index = state.items.indexOf(item);
      if (index < 0) {
        return;
      }

      state.items.splice(index, 1);
    }
  },
  getters: {
    items (state) {
      return state.items;
    },
    completedItems (state) {
      return state.items.filter((item) => {
        return item.completed;
      });
    },
    openItems (state) {
      return state.items.filter((item) => {
        return !item.completed;
      });
    }
  },
  actions: {
    fetchItems ({ commit }) {
      TodosApi.fetchItems().then(function (items) {
        commit('setItems', items);
      });
    },
    addItem ({ commit }, item) {
      commit('addItem', item);
      TodosApi.insertItem(item);
    },
    deleteItem({ commit }, item) {
      commit('deleteItem', item);
      TodosApi.deleteItem(item);
    },
    toggleCompleted({ commit }, item) {
      item.completed = !item.completed;
      commit('updateItem', Object.assign({}, { ...item }));
      TodosApi.updateItem(item);
    }
  }
});

export default store;
