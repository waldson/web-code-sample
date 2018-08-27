import axios from 'axios';
import moment from 'moment';

class TodosApi {

  fetchItems () {
    return axios.get('/todos')
      .then(function (response) {
        return response.data.map((item) => {
          item.completed  = item.completed == 1;
          item.created_at = moment(item.created_at).toDate();

          if (item.completed_at) {
            item.completed_at = moment(item.completed_at).toDate();
          }

          return item;
        });
      });
  }

  updateItem (item) {
    return axios.put('/todos/' + item.uuid, item);
  }

  deleteItem (item) {
    return axios.delete('/todos/' + item.uuid);
  }

  insertItem (item) {
    return axios.post('/todos', item);
  }

}

export default new TodosApi();

