//import './scss/app.scss';
//import './js/all'

// assets/app.js
import { registerReactControllerComponents } from '@symfony/ux-react';
registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));
