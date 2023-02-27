import './shared';
import './modules/front';

// Assets
import './modules/front/style.scss';


// Webpack HMR
if (module.hot) {
	module.hot.accept();
  }
