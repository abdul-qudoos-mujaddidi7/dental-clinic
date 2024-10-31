<template>
  
    <v-list density="compact" nav>
        <v-list-item
            prepend-icon="mdi-home-city"
            title="Home"
            value="home"
        ></v-list-item>
        <v-list-item
            prepend-icon="mdi-account"
            title="My Account"
            value="account"
        ></v-list-item>
        <v-list-item
            prepend-icon="mdi-account-group-outline"
            title="Users"
            value="users"
        ></v-list-item>
    </v-list>
    <v-divider></v-divider>
    <v-list-item
        prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
        title="John Leider"
        nav
    >
    </v-list-item>
</template>
<script setup></script>
