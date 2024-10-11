<template>
      <v-app>
    <v-container>
      <v-btn color="primary">Test Button</v-btn>
    </v-container>
  </v-app>
    <div>
        <h1>In the name of Allah!</h1>
        <h1>front is ok</h1>
    </div>
    <h1 class="text-4xl  underline">
    Hello world!
  </h1>
  <table class="min-w-full table-auto border-collapse border border-gray-300">
  <thead>
    <tr class="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 text-white">
      <th class="px-6 py-3 text-left border-b border-gray-300">Name</th>
      <th class="px-6 py-3 text-left border-b border-gray-300">Age</th>
      <th class="px-6 py-3 text-left border-b border-gray-300">Email</th>
    </tr>
  </thead>
  <tbody>
    <tr class="bg-blue-100 hover:bg-blue-200 transition duration-300">
      <td class="px-6 py-4 border-b border-gray-300">John Doe</td>
      <td class="px-6 py-4 border-b border-gray-300">25</td>
      <td class="px-6 py-4 border-b border-gray-300">john@example.com</td>
    </tr>
    <tr class="bg-green-100 hover:bg-green-200 transition duration-300">
      <td class="px-6 py-4 border-b border-gray-300">Jane Smith</td>
      <td class="px-6 py-4 border-b border-gray-300">30</td>
      <td class="px-6 py-4 border-b border-gray-300">jane@example.com</td>
    </tr>
    <tr class="bg-yellow-100 hover:bg-yellow-200 transition duration-300">
      <td class="px-6 py-4 border-b border-gray-300">Mike Johnson</td>
      <td class="px-6 py-4 border-b border-gray-300">28</td>
      <td class="px-6 py-4 border-b border-gray-300">mike@example.com</td>
    </tr>
    <tr class="bg-pink-100 hover:bg-pink-200 transition duration-300">
      <td class="px-6 py-4 border-b border-gray-300">Emily Davis</td>
      <td class="px-6 py-4 border-b border-gray-300">22</td>
      <td class="px-6 py-4 border-b border-gray-300">emily@example.com</td>
    </tr>
  </tbody>
</table>
<!-- ================= -->
 <hr>
 <v-card
  loading
  title="Card title"
  subtitle="Subtitle"
  text="..."
>
  <v-card-actions>
    <v-btn>Click me</v-btn>
  </v-card-actions>
</v-card>

</template>

<script>
export default {
    name: 'ExampleComponent'
}
</script>

<style scoped>
/* Your styles here */
</style>
