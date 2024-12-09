<script setup>
import AddUser from './form/AddUser.vue';


// 👉 Store
const searchQuery = ref("");
const selectedRole = ref();
const selectedPlan = ref();
const selectedStatus = ref();

// Data table options
const itemsPerPage = ref(10);
const page = ref(1);
const sortBy = ref();
const orderBy = ref();
const selectedRows = ref([]);

const updateOptions = (options) => {
  sortBy.value = options.sortBy[0]?.key;
  orderBy.value = options.sortBy[0]?.order;
};

// Headers
const headers = [
  {
    title: "Usuario",
    key: "user",
  },
  {
    title: "Roles",
    key: "role",
  },
  {
    title: "usuario acceso",
    key: "plan",
  },
  {
    title: "Estado",
    key: "status",
  },
  {
    title: "Actions",
    key: "actions",
    sortable: false,
  },
];

const { data: usersData, execute: fetchUsers } = await useApi(
  createUrl("/apps/users", {
    query: {
      q: searchQuery,
      status: selectedStatus,
      plan: selectedPlan,
      role: selectedRole,
      itemsPerPage,
      page,
      sortBy,
      orderBy,
    },
  })
);

const users = computed(() => usersData.value.users);
const totalUsers = computed(() => usersData.value.totalUsers);

// 👉 search filters
const roles = [
  {
    title: "Admin",
    value: "admin",
  },
  {
    title: "Author",
    value: "author",
  },
  {
    title: "Editor",
    value: "editor",
  },
  {
    title: "Maintainer",
    value: "maintainer",
  },
  {
    title: "Subscriber",
    value: "subscriber",
  },
];

const plans = [
  {
    title: "Basic",
    value: "basic",
  },
  {
    title: "Company",
    value: "company",
  },
  {
    title: "Enterprise",
    value: "enterprise",
  },
  {
    title: "Team",
    value: "team",
  },
];

const status = [
  {
    title: "Pending",
    value: "pending",
  },
  {
    title: "Active",
    value: "active",
  },
  {
    title: "Inactive",
    value: "inactive",
  },
];

const resolveUserRoleVariant = (role) => {
  const roleLowerCase = role.toLowerCase();
  if (roleLowerCase === "subscriber")
    return {
      color: "success",
      icon: "bx-user",
    };
  if (roleLowerCase === "author")
    return {
      color: "error",
      icon: "bx-desktop",
    };
  if (roleLowerCase === "maintainer")
    return {
      color: "info",
      icon: "bx-pie-chart-alt",
    };
  if (roleLowerCase === "editor")
    return {
      color: "warning",
      icon: "bx-edit",
    };
  if (roleLowerCase === "admin")
    return {
      color: "primary",
      icon: "bx-crown",
    };

  return {
    color: "primary",
    icon: "bx-user",
  };
};

const resolveUserStatusVariant = (stat) => {
  const statLowerCase = stat.toLowerCase();
  if (statLowerCase === "pending") return "warning";
  if (statLowerCase === "active") return "success";
  if (statLowerCase === "inactive") return "secondary";

  return "primary";
};

const isAddNewUserDrawerVisible = ref(false);

const addNewUser = async (userData) => {
  await $api("/apps/users", {
    method: "POST",
    body: userData,
  });

  // Refetch User
  fetchUsers();
};

const deleteUser = async (id) => {
  await $api(`/apps/users/${id}`, { method: "DELETE" });

  // Delete from selectedRows
  const index = selectedRows.value.findIndex((row) => row === id);
  if (index !== -1) selectedRows.value.splice(index, 1);

  // Refetch User
  fetchUsers();
};

const widgetData = ref([
  {
    title: "Session",
    value: "21,459",
    change: 29,
    desc: "Total Users",
    icon: "bx-group",
    iconColor: "primary",
  },
  {
    title: "Paid Users",
    value: "4,567",
    change: 18,
    desc: "Last Week Analytics",
    icon: "bx-user-plus",
    iconColor: "error",
  },
  {
    title: "Active Users",
    value: "19,860",
    change: -14,
    desc: "Last Week Analytics",
    icon: "bx-user-check",
    iconColor: "success",
  },
  {
    title: "Pending Users",
    value: "237",
    change: 42,
    desc: "Last Week Analytics",
    icon: "bx-user-voice",
    iconColor: "warning",
  },
]);
</script>

<template>
  

  <VCard v-if="!isAddNewUserDrawerVisible" class=" pt-0">
    <VCardText class="d-flex flex-wrap gap-4 pt-0">
      <div class="me-3 d-flex gap-3">
        <AppSelect
          :model-value="itemsPerPage"
          :items="[
            { value: 10, title: '10' },
            { value: 25, title: '25' },
            { value: 50, title: '50' },
            { value: 100, title: '100' },
            { value: -1, title: 'All' },
          ]"
          style="inline-size: 6.25rem"
          @update:model-value="itemsPerPage = parseInt($event, 10)"
        />
      </div>
      <VSpacer />

      <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">
        <!-- 👉 Search  -->
        <div style="inline-size: 15.625rem">
          <AppTextField v-model="searchQuery" placeholder="Search User" />
        </div>

        <!-- 👉 Export button -->
        <VBtn variant="tonal" color="secondary" prepend-icon="bx-export">
          Export
        </VBtn>

        <!-- 👉 Add user button -->
        <VBtn prepend-icon="bx-plus" @click="isAddNewUserDrawerVisible = true">
          Add New User
        </VBtn>
      </div>
    </VCardText>
    <VDivider />

    <!-- SECTION datatable -->
    <VDataTableServer
      v-model:items-per-page="itemsPerPage"
      v-model:model-value="selectedRows"
      v-model:page="page"
      :items="users"
      height="615"
      item-value="id"
      :items-length="totalUsers"
      :headers="headers"
      class="text-no-wrap"
      @update:options="updateOptions"
    >
      <!-- User -->
      <template #item.user="{ item }">
        <div class="d-flex align-center gap-x-4">
          <VAvatar
            size="34"
            :variant="!item.avatar ? 'tonal' : undefined"
            :color="
              !item.avatar ? resolveUserRoleVariant(item.role).color : undefined
            "
          >
            <VImg v-if="item.avatar" :src="item.avatar" />
            <span v-else>{{ avatarText(item.fullName) }}</span>
          </VAvatar>
          <div class="d-flex flex-column">
            <h6 class="text-base">
              <RouterLink
                :to="{ name: 'apps-user-view-id', params: { id: item.id } }"
                class="font-weight-medium text-link"
              >
                {{ item.fullName }}
              </RouterLink>
            </h6>
            <div class="text-sm">
              {{ item.email }}
            </div>
          </div>
        </div>
      </template>

      <!-- 👉 Role -->
      <template #item.role="{ item }">
        <div class="d-flex align-center gap-x-2">
          <VIcon
            :size="20"
            :icon="resolveUserRoleVariant(item.role).icon"
            :color="resolveUserRoleVariant(item.role).color"
          />

          <div class="text-capitalize text-high-emphasis text-body-1">
            {{ item.role }}
          </div>
        </div>
      </template>

      <!-- Plan -->
      <template #item.plan="{ item }">
        <div class="text-body-1 text-high-emphasis text-capitalize">
          {{ item.currentPlan }}
        </div>
      </template>

      <!-- Status -->
      <template #item.status="{ item }">
        <VChip
          :color="resolveUserStatusVariant(item.status)"
          size="small"
          label
          class="text-capitalize"
        >
          {{ item.status }}
        </VChip>
      </template>

      <!-- Actions -->
      <template #item.actions="{ item }">
        <IconBtn @click="deleteUser(item.id)">
          <VIcon icon="bx-trash" />
        </IconBtn>

        <IconBtn>
          <VIcon icon="bx-show" />
        </IconBtn>

        <VBtn icon variant="text" color="medium-emphasis">
          <VIcon icon="bx-dots-vertical-rounded" />
          <VMenu activator="parent">
            <VList>
              <VListItem
                :to="{ name: 'apps-user-view-id', params: { id: item.id } }"
              >
                <template #prepend>
                  <VIcon icon="bx-show" />
                </template>

                <VListItemTitle>View</VListItemTitle>
              </VListItem>

              <VListItem link>
                <template #prepend>
                  <VIcon icon="bx-pencil" />
                </template>
                <VListItemTitle>Edit</VListItemTitle>
              </VListItem>
            </VList>
          </VMenu>
        </VBtn>
      </template>

      <!-- pagination -->
      <template #bottom>
        <TablePagination
          v-model:page="page"
          :items-per-page="itemsPerPage"
          :total-items="totalUsers"
        />
      </template>
    </VDataTableServer>
    <!-- SECTION -->
 
  </VCard>
  <!-- 👉 Add New User -->
  <VCard class=" pt-0">
    <AddUser  v-model:isDrawerOpen="isAddNewUserDrawerVisible"
    @user-data="addNewUser"/>
  </VCard>
</template>
