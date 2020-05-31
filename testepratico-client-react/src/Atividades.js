import React, { Component } from 'react';
import { Header, Message, Table } from 'semantic-ui-react';
import { withAuth } from '@okta/okta-react';

import { API_BASE_URL } from './config'
import AtividadeForm from './AtividadeForm';

export default withAuth(class Atividades extends Component {

    constructor(props) {
        super(props);
        this.state = {
            atividades: null,
            isLoading: null
        };
        this.onAddition = this.onAddition.bind(this);
        this.onIncrease = this.onIncrease.bind(this);
    }

    componentDidMount() {
        this.getAtividades();
    }

    async getAtividades() {
        if (!this.state.atividades) {
            try {
                this.setState({ isLoading: true });
                const accessToken = await this.props.auth.getAccessToken();
                const response = await fetch(API_BASE_URL + '/atividades', {
                    headers: {
                        Authorization: `Bearer ${accessToken}`,
                    },
                });
                const data = await response.json();
                this.setState({ atividades: data, isLoading: false});
            } catch (err) {
                this.setState({ isLoading: false });
                console.error(err);
            }
        }
    }

    onAddition(atividade) {
        this.setState({
            atividades: [...this.state.atividades, atividade]
        })
    }


    render() {
        return (
            <div>
                <Header as="h1">My Atividades</Header>
                {this.state.isLoading && <Message info header="Loading atividades..." />}
                {this.state.atividades &&
                    <div>
                        <Table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                </tr>
                            </thead>
                            <tbody>
                            {this.state.atividades.map(
                                    atividade => 
                                        <tr id={atividade.id} key={atividade.id}>
                                            <td>{atividade.id}</td>
                                            <td>{atividade.title}</td>
                                        </tr>
                            )}
                            </tbody>
                        </Table>
                        <AtividadeForm onAddition={this.onAddition} />
                    </div>
                }
            </div>
        );
    }
});