import React, { Component } from 'react';
import { BrowserRouter as Router, Route } from 'react-router-dom';
import { Container } from 'semantic-ui-react';

import { Security, SecureRoute, ImplicitCallback } from '@okta/okta-react';

import Navbar from './Navbar';
import Home from './Home'
import Atividades from './Atividades'

const config = {
    issuer: 'https://{Issuer URI}.okta.com',
    redirect_uri: window.location.origin + '/implicit/callback',
    client_id: 'Client ID '
}

class App extends Component {
  render() {
    return (
        <Router>
            <Security issuer={config.issuer}
                   client_id={config.client_id}
                redirect_uri={config.redirect_uri}
            >
            <Navbar />
            <Container text style={{ marginTop: '7em' }}>
                <Route path="/" exact component={Home} />
                <Route path="/implicit/callback" component={ImplicitCallback} />
                <SecureRoute path="/atividades" component={Atividades} />
            </Container>
        </Security>
      </Router>
    );
  }
}

export default App