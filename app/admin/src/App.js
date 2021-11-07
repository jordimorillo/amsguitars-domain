// in src/App.js
import * as React from "react";
import { Admin, Resource, EditGuesser } from 'react-admin';
import {PostCreate, PostEdit, PostList} from './pages/posts';
import { UserList } from './pages/users';
import Dashboard from './pages/Dashboard';
import jsonServerProvider from 'ra-data-json-server';
import PostIcon from '@material-ui/icons/Book';
import UserIcon from '@material-ui/icons/Group';
import authProvider from './providers/authProvider';
// import dataProvider from './providers/dataProvider';
const dataProvider = jsonServerProvider('https://jsonplaceholder.typicode.com');

const App = () => (
    <Admin dashboard={Dashboard} authProvider={authProvider} dataProvider={dataProvider}>
        <Resource name="posts" list={PostList} edit={PostEdit} create={PostCreate} icon={PostIcon} />
        <Resource name="users" list={UserList} icon={UserIcon} />
    </Admin>
);

export default App;