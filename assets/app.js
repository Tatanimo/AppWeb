import './bootstrap.js';
import { registerReactControllerComponents } from '@symfony/ux-react';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));