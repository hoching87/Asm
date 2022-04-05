import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Space, Card, Typography, Image, Text, Divider } from 'antd';
const { Title } = Typography;
const { Meta } = Card;


function Home(props) {
    console.log(props)
    const [contents, setContents] = useState();
    useEffect(() => {
        getProducts()
    }, [])

    const getProducts = async () => {
        const res = await axios.get(window.location.origin + '/api/home');
        console.log('getProducts', res.data)
        console.log(props)
        
        setContents(res.data)
    }

    const viewProducts = ()=>{
        if(props.admin ==1)
        {
            window.location.href = window.location.origin + '/editProducts'
        }
        else
        {
            window.location.href = window.location.origin + '/products'
        }
    }

    return (
        
        <Space direction="vertical" size="middle"
            style={{ display: 'flex', padding: 10, height: '100vh' }}>
            <Divider />
            
            <Title level={4}>Our Products</Title>
            <Space wrap>
                {
                    
                    contents?.products.map(product => {
                        return (
                            <Card key={product.id}
                            
                                hoverable
                                style={{ width: 200 }}
                                cover={<img alt="example" src={window.location.origin + `/uploads/images/${product.bouquetImage}`} />}
                                
                                onClick={() => viewProducts()}
                            >
                                <Meta title={product.bouequetName} description={`RM${product.bouequetPrice}`} />
                                
                            </Card>
                        )
                    })
                }
            </Space>
            <Divider />
            <Title level={4}>Blogs</Title>
            <Space wrap>
                {
                    contents?.blogs.map(blog => {
                        return (
                            <Card
                                hoverable
                                style={{ width: 250 }}
                                title={blog.author}
                                onClick={() => window.location.href = blog.link}
                                key={blog.id}
                            >
                                <img alt="example" src={window.location.origin + `/uploads/images/${blog.pictures}`} style={{ width: 200 }} />
                                {blog.blogTitle}
                            </Card>
                        )
                    })
                }
            </Space>
            <Divider />
        </Space >
    );
}

export default Home;

let root = document.getElementById('home')
if (root) {
    ReactDOM.render(<Home {...(root.dataset)} />, root);
}