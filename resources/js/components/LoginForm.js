import React from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Form, Input, Button, Checkbox, Card, message, Space, Typography, Divider } from 'antd';
const { Title, Link, Text } = Typography;

function LoginForm(props) {
    const onFinish = async (values) => {
        try {
            const res = await axios.post(window.location.origin + '/auth/login', values)
            if (res.status == 200) {
                message.success('Login Success!');
                window.location.replace(window.location.origin + "/home");
            }
        } catch (err) {
            message.error('Login Failed!');
        }
    };

    const onFinishFailed = (errorInfo) => {
        message.error('Login Error!');
    };

    return (
        <Space align="baseline" style={{ display: 'flex', justifyContent: 'center', paddingTop: '5vh' }}>
            <Card title='Login' style={{ width: '50vw' }}>
                <Form
                    name="basic"
                    initialValues={{ remember: true }}
                    onFinish={onFinish}
                    onFinishFailed={onFinishFailed}
                    autoComplete="on"
                >
                    <Form.Item
                        label="Email"
                        name="email"
                        rules={[{ required: true, message: 'Please input your username!' }]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item
                        label="Password"
                        name="password"
                        rules={[{ required: true, message: 'Please input your password!' }]}
                    >
                        <Input.Password />
                    </Form.Item>

                    <Form.Item name="remember" valuePropName="checked" wrapperCol={{ offset: 8, span: 16 }}>
                        <Checkbox>Remember Me</Checkbox>
                    </Form.Item>

                    <Form.Item wrapperCol={{ offset: 8, span: 16 }}>
                        <Button type="primary" htmlType="submit">
                            Submit
                        </Button>
                    </Form.Item>
                </Form>
                <Divider></Divider>
                <Text>Dont have a account? </Text>
                <Link href={window.location.origin + '/register'} >
                    Register
                </Link>
            </Card>
        </Space >
    );
}

export default LoginForm;

let root = document.getElementById('loginform')
if (root) {
    ReactDOM.render(<LoginForm {...(root.dataset)} />, root);
}