<template>
  <v-simple-table
    class="pa-6"
    fixed-header
    height="300px"
    dense
  >
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">
            #
          </th>
          <th class="text-left">
            Name
          </th>
          <th class="text-left">
            Email
          </th>
          <th class="text-left">
            Phone
          </th>
          <th class="text-left">
            Message
          </th>
          <th class="text-left">
            Date
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in desserts"
          :key="item.id"
        >
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.email }}</td>
          <td>{{ item.phone }}</td>
          <td>{{ item.message }}</td>
          <td>{{ item.created_at }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>
<script>
  export default {
    data () {
      return {
        desserts: [ ],
      }
    },
    mounted(){
        axios
          .get('contact/get/messages')
          .then(response => (this.desserts = response.data));

    }
  }
</script>
