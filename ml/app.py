from flask import Flask , jsonify
from fetch_data import get_data_from_ci4
from main import hobbyShop

app = Flask(__name__)
ml_system = hobbyShop()

@app.route('/analyze')
def analyze():
    data = get_data_from_ci4()
    if not data:
        return jsonify({'error': 'Failed to fetch data from CI4'}),500
    
    ml_system.train(data['transactions'] , data['products'])
    report = ml_system.generate_report(
        data['products'],
        data['transactions']
    )
    return jsonify(report)

if __name__ == '__main__':
    app.run(debug=True , port=5000)